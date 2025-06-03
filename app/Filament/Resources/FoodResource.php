<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FoodResource\Pages;
use App\Filament\Resources\FoodResource\RelationManagers;
use App\Models\Food;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FoodResource extends Resource
{
    protected static ?string $model = Food::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('name')
                ->required()
                ->maxLength(255),

            Select::make('category')
                ->options([
                    'protein' => 'Protein',
                    'karbo' => 'Karbohidrat',
                    'sayur' => 'Sayuran',
                    'buah' => 'Buah',
                    // tambahkan kategori lain jika perlu
                ])
                ->required(),

            Select::make('meal_time')
                ->options([
                    'breakfast' => 'Breakfast',
                    'lunch' => 'Lunch',
                    'dinner' => 'Dinner',
                ])
                ->required(),

            Select::make('bmi_category')
                ->options([
                    'underweight' => 'Underweight',
                    'normal' => 'Normal',
                    'overweight' => 'Overweight',
                    'obese' => 'Obese',
                ])
                ->required(),

            TextInput::make('portion_size_grams')
                ->numeric()
                ->required()
                ->label('Portion Size (grams)'),

            TextInput::make('calories')
                ->numeric()
                ->required(),

            TextInput::make('protein_g')
                ->numeric()
                ->required()
                ->label('Protein (g)'),

            TextInput::make('carbs_g')
                ->numeric()
                ->required()
                ->label('Carbs (g)'),

            TextInput::make('fat_g')
                ->numeric()
                ->required()
                ->label('Fat (g)'),

            Textarea::make('note')
                ->nullable()
                ->label('Additional Notes'),
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('name')->sortable()->searchable(),
            TextColumn::make('category')->sortable()->label('Category'),
            TextColumn::make('meal_time')->sortable()->label('Meal Time')->formatStateUsing(fn($state) => ucfirst($state)),
            TextColumn::make('bmi_category')->sortable()->label('BMI Category')->formatStateUsing(fn($state) => ucfirst($state)),
            TextColumn::make('portion_size_grams')->label('Portion (g)'),
            TextColumn::make('calories')->label('Calories'),
            TextColumn::make('protein_g')->label('Protein (g)'),
            TextColumn::make('carbs_g')->label('Carbs (g)'),
            TextColumn::make('fat_g')->label('Fat (g)'),
            TextColumn::make('note')->label('Notes')->limit(20)->toggleable(),
        ])

        ->filters([
            SelectFilter::make('bmi_category')
                ->label('BMI Category')
                ->options([
                    'underweight' => 'Underweight',
                    'normal' => 'Normal',
                    'overweight' => 'Overweight',
                    'obese' => 'Obese',
                ]),

            SelectFilter::make('meal_time')
                ->label('Meal Time')
                ->options([
                    'breakfast' => 'Breakfast',
                    'lunch' => 'Lunch',
                    'dinner' => 'Dinner',
                ]),

            SelectFilter::make('category')
                ->label('Category')
                ->options([
                    'protein' => 'Protein',
                    'karbo' => 'Karbohidrat',
                    'sayur' => 'Sayur',
                    'buah' => 'Buah',
                    // Tambahkan jika ada kategori lain
                ]),
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
            'index' => Pages\ListFood::route('/'),
            'create' => Pages\CreateFood::route('/create'),
            'edit' => Pages\EditFood::route('/{record}/edit'),
        ];
    }
}
