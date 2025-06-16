<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ForumResource\Pages;
use App\Filament\Resources\ForumResource\RelationManagers;
use App\Models\Forum;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ForumResource extends Resource
{
    protected static ?string $model = Forum::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // TextInput::make('ForumTitle')->required(),
                // Textarea::make('ForumContent')->required(),
                // FileUpload::make('ForumImage')->image()->nullable(),
                // Select::make('ForumCreator')
                //     ->label('Forum Creator')
                //     ->relationship('creator', 'name') // pastikan relasinya benar
                //     ->searchable()
                //     ->required(),
                // DatePicker::make('CreatedAt')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ForumTitle')
                    ->label('Title')
                    ->sortable()
                    ->searchable(),


                    // ImageColumn::make('ForumImage')
                    // ->label('Image')
                    // ->size(50)
                    // ->circular() // opsional, biar bulet
                    // ->url(fn ($record) => $record->ForumImage
                    //     ? asset('storage/forumimages/' . $record->ForumImage)
                    //     : null
                    // )
                    // ->defaultImageUrl(asset('images/noimage.png')), // jika kosong
                // TextColumn::make('ForumImage')->label('Nama File Gambar'),

                // ImageColumn::make('ForumImage')
                //     ->label('Image')
                //     ->size(50) // atur ukuran (width & height) dalam pixel
                //     ->url(fn ($record) => asset('storage/forumimages/' . $record->ForumImage)),
                ImageColumn::make('image_path') // Buat kolom "virtual" atau gunakan accessor di model
                ->label('Image')
                ->getStateUsing(fn ($record) => asset('storage/forumimages/' . $record->ForumImage))
                ->size(50)
                ->url(fn ($record) => asset('storage/forumimages/' . $record->ForumImage)), // Pastikan URL klik juga sama

                TextColumn::make('ForumContent')
                    ->label('Content Preview')
                    ->limit(50)  // hanya tampilkan 50 karakter saja
                    ->wrap(),    // biar kalau panjang bisa multiline

                TextColumn::make('creator.name')
                    ->label('Creator')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('CreatedAt')
                    ->label('Created Date')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListForums::route('/'),
            'create' => Pages\CreateForum::route('/create'),
            'edit' => Pages\EditForum::route('/{record}/edit'),
        ];
    }
}
