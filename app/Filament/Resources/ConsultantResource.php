<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConsultantResource\Pages;
use App\Filament\Resources\ConsultantResource\RelationManagers;
use App\Models\Consultant;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ConsultantResource extends Resource
{
    protected static ?string $model = Consultant::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Fieldset::make('Consultant Information')->schema([
                TextInput::make('name')
                    ->label('Full Name')
                    ->required()
                    ->maxLength(255),

                Select::make('gender')
                    ->label('Gender')
                    ->options([
                        'Male' => 'Male',
                        'Female' => 'Female',
                        'Other' => 'Other',
                    ])
                    ->required(),

                DatePicker::make('dob')
                    ->label('Date of Birth')
                    ->required(),

                TextInput::make('specialization')
                    ->label('Specialization')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Email Address')
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->required(),

                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required()
                    ->minLength(8)
                    ->maxLength(50),

                TextInput::make('phone')
                    ->label('Phone Number')
                    ->tel()
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->maxLength(15),

                TextInput::make('experience')
                    ->label('Years of Experience')
                    ->numeric()
                    ->minValue(0)
                    ->required(),

                TextInput::make('price_per_session')
                    ->label('Price per Session')
                    ->numeric()
                    ->prefix('$')
                    ->minValue(0)
                    ->required(),

                Toggle::make('is_available')
                    ->label('Available for New Sessions')
                    ->inline(false),

                Toggle::make('is_online')
                    ->label('Currently Online')
                    ->disabled(), // Tidak bisa diubah manual, hanya bisa diubah otomatis saat login/logout

                TimePicker::make('available_from')
                    ->label('Available From'),

                TimePicker::make('available_to')
                    ->label('Available To'),
            ])
                    ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('1s')
            ->columns([
                // TextColumn::make('id')->label('ID')->sortable(),
                // TextColumn::make('name')->label('Name')->searchable(),
                // TextColumn::make('specialization')->label('Specialization')->searchable(),
                // TextColumn::make('email')->label('Email')->searchable(),
                // TextColumn::make('phone')->label('Phone')->searchable(),
                // TextColumn::make('experience')->label('Experience (Years)')->sortable(),
                // TextColumn::make('created_at')->label('Joined At')->dateTime()->sortable(),
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('name')->label('Name')->searchable(),
                TextColumn::make('gender')->label('Gender')->sortable(),
                TextColumn::make('dob')->label('Date of Birth')->date()->sortable(),
                TextColumn::make('specialization')->label('Specialization')->searchable(),
                TextColumn::make('email')->label('Email')->searchable(),
                TextColumn::make('phone')->label('Phone')->searchable(),
                TextColumn::make('experience')->label('Experience (Years)')->sortable(),
                TextColumn::make('price_per_session')->label('Price per Session')->money('IDR')->sortable(),
                IconColumn::make('is_available')
                    ->label('Available')
                    ->boolean(),
                IconColumn::make('is_online')
                    ->label('Online')
                    ->boolean(),
                TextColumn::make('available_from')->label('Available From')->time()->sortable(),
                TextColumn::make('available_to')->label('Available To')->time()->sortable(),
                TextColumn::make('created_at')->label('Joined At')->dateTime()->sortable(),

            ])
            ->filters([
                //
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
            'index' => Pages\ListConsultants::route('/'),
            'create' => Pages\CreateConsultant::route('/create'),
            'edit' => Pages\EditConsultant::route('/{record}/edit'),
        ];
    }
}
