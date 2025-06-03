<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeliveriesResource\Pages;
use App\Filament\Resources\DeliveriesResource\RelationManagers;
use App\Models\Deliveries;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeliveriesResource extends Resource
{
    protected static ?string $model = Deliveries::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order.order_number')->label('Order'),
                TextColumn::make('courier.name')->label('Courier'),
                TextColumn::make('delivery_status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'assigned' => 'gray',
                        'picking_up' => 'info',
                        'on_the_way' => 'warning',
                        'delivered' => 'success',
                        'failed' => 'danger',
                    }),
                TextColumn::make('pickup_at')->dateTime(),
                TextColumn::make('delivered_at')->dateTime(),
                ImageColumn::make('proof_of_delivery_image')->label('Proof')->size(50),
                TextColumn::make('created_at')->since(),
            ])->defaultSort('created_at', 'desc')
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
            'index' => Pages\ListDeliveries::route('/'),
            'create' => Pages\CreateDeliveries::route('/create'),
            'edit' => Pages\EditDeliveries::route('/{record}/edit'),
        ];
    }
}
