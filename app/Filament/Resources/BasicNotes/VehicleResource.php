<?php

namespace App\Filament\Resources\BasicNotes;

use App\Filament\Resources\BasicNotes;
use App\Filament\Resources\BasicNotes\VehicleResource\Pages;
use App\Filament\Resources\BasicNotes\VehicleResource\RelationManagers;
use App\Helpers\ImportantParameterHelper;
use App\Models\Vehicle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;

    protected static ?string $navigationGroup = 'basic_notes';

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?int $navigationSort = 19;

    public static function getModelLabel(): string
    {
        return trans('f28.Vehicles');
    }

    public static function getNavigationLabel(): string
    {
        return trans('f28.Vehicles');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('f28.Vehicles');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Department (FK to departments)
                Forms\Components\Select::make('department_id')
                    ->label(__('f28.department'))
                    ->relationship('department', 'department') // Assuming 'name' is a field in departments
                    //->searchable()
                    ->required(),

                // Vehicle Number
                Forms\Components\TextInput::make('vehicle_number')
                    ->label(__('f28.vehicle_number'))
                    ->required()
                    ->maxLength(30)
                    ->unique(),

                // Fuel Quality Level
                Forms\Components\TextInput::make('fuel_quality_level')
                    ->label(__('f28.fuel_quality_level'))
                    ->nullable()
                    ->maxLength(10),

                // Fuel Type (Dropdown with data from ImportantParameterHelper)
                Forms\Components\Select::make('fuel_type')
                    ->label(__('f28.fuel_type'))
                    ->options(ImportantParameterHelper::getValues('fuel_types')) // Get fuel types from helper
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('department.department')->label(__('f28.department'))->sortable()->searchable(),
                TextColumn::make('vehicle_number')->label(__('f28.vehicle_number'))->sortable()->searchable(),
                TextColumn::make('fuel_quality_level')->label(__('f28.fuel_quality_level'))->sortable()->searchable(),
                TextColumn::make('fuel_type')
                    ->formatStateUsing(function ($state) {
                        // Fetch the label for the stored value from ImportantParameter
                        $vehicle = ImportantParameterHelper::getValues('fuel_types');
                        return $vehicle[$state] ?? $state; // Return the label or the raw value if not found
                    })
                    ->label(__('f28.fuel_type'))->sortable()->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->modal(),
                Tables\Actions\EditAction::make()->modal(),
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
            'index' => BasicNotes\VehicleResource\Pages\ListVehicles::route('/'),
        ];
    }
}
