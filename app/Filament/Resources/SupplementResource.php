<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupplementResource\Pages;
use App\Filament\Resources\SupplementResource\RelationManagers;
use App\Models\Supplement;
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
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class SupplementResource extends Resource
{
    protected static ?string $model = Supplement::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Supplement Name')
                    ->required()
                    ->maxLength(255),

                Select::make('category')
                    ->label('Category')
                    ->options([
                        'vitamin' => 'Vitamin',
                        'protein' => 'Protein',
                    ])
                    ->required(),

                Select::make('bmi_category')
                    ->label('BMI Category')
                    ->options([
                        'underweight' => 'Underweight',
                        'normal' => 'Normal',
                        'overweight' => 'Overweight',
                        'obese' => 'Obese',
                    ])
                    ->required(),

                Textarea::make('description')
                    ->label('Description')
                    ->maxLength(500),

                TextInput::make('price')
                    ->label('Price')
                    ->numeric()
                    ->required(),

                TextInput::make('stock')
                    ->label('Stock')
                    ->numeric()
                    ->required(),

                DatePicker::make('expired_at')
                    ->label('Expiration Date')
                    ->nullable(),

                FileUpload::make('image')
                    ->label('Supplement Image')
                    ->image()
                    ->directory('supplements')
                    ->imagePreviewHeight('250')
                    ->maxSize(2048),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('name')->label('Name')->searchable(),
                TextColumn::make('category')->label('Category')->searchable(),
                TextColumn::make('bmi_category')->label('BMI Category')->sortable()->searchable(),
                TextColumn::make('price')->label('Price')->money('IDR')->searchable(),
                TextColumn::make('stock')->label('Stock')->sortable(),
                ImageColumn::make('image')->label('Image')->size(50)->url(fn($record) => asset('storage/' . $record->logo)),
                TextColumn::make('expired_at')->label('Expires At')->date(),
            ])
            ->defaultSort('expired_at', 'asc')
            ->filters([
                Filter::make('expired')
                    ->label('Expired Supplements')
                    ->query(fn (Builder $query) => $query->whereDate('expired_at', '<', now())),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListSupplements::route('/'),
            'create' => Pages\CreateSupplement::route('/create'),
            'edit' => Pages\EditSupplement::route('/{record}/edit'),
        ];
    }
}
