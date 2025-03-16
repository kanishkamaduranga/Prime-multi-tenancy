<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VehiclesRentedResource\Pages;
use App\Filament\Resources\VehiclesRentedResource\RelationManagers;
use App\Models\VehiclesRented;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Helpers\ImportantParameterHelper;
use Filament\Tables\Columns\TextColumn;

class VehiclesRentedResource extends Resource
{
    protected static ?string $model = VehiclesRented::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationGroup = 'Basic Notes';

    public static function getModelLabel(): string
    {
        return trans('f28.Vehicles_rented');
    }

    public static function getNavigationLabel(): string
    {
        return trans('f28.Vehicles_rented');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('f28.Vehicles_rented');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Year (Default to current year)
                Forms\Components\TextInput::make('year')
                    ->label(__('f28.year'))
                    ->default(date('Y')) // Default to current year
                    ->required(),

                // Month (Default to current month)
                Forms\Components\TextInput::make('month')
                    ->label(__('f28.month'))
                    ->default(date('F')) // Default to current month
                    ->required(),

                // Vehicle Number
                Forms\Components\TextInput::make('vehicle_number')
                    ->label(__('f28.vehicle_number'))
                    ->required()
                    ->maxLength(20),

                // Payment Method (Dropdown with data from ImportantParameterHelper)
                Forms\Components\Select::make('payment_method')
                    ->label(__('f28.payment_method'))
                    ->options(ImportantParameterHelper::getValues('vehicle_payment_types')) // Get payment methods from helper
                    ->required(),

                // Price
                Forms\Components\TextInput::make('price')
                    ->label(__('f28.price'))
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('year')->label(__('f28.year'))->sortable()->searchable(),
                TextColumn::make('month')->label(__('f28.month'))->sortable()->searchable(),
                TextColumn::make('vehicle_number')->label(__('f28.vehicle_number'))->sortable()->searchable(),
                TextColumn::make('payment_method')
                    ->formatStateUsing(function ($state) {
                        // Fetch the label for the stored value from ImportantParameter
                        $vehicle_payment_types = ImportantParameterHelper::getValues('vehicle_payment_types');
                        return $vehicle_payment_types[$state] ?? $state; // Return the label or the raw value if not found
                    })
                    ->label(__('f28.payment_method'))->sortable()->searchable(),
                TextColumn::make('price')->label(__('f28.price'))->sortable()->money('LKR'), // Format as currency
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListVehiclesRenteds::route('/'),
        ];
    }
}
