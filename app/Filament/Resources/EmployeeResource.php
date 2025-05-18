<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Helpers\ImportantParameterHelper;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;


class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationGroup = 'basic_notes';

    protected static ?int $navigationSort = 20;

    public static function getModelLabel(): string
    {
        return trans('f28.Employee_information');
    }

    public static function getNavigationLabel(): string
    {
        return trans('f28.Employee_information');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('f28.Employee_information');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Employee Number (auto-generated, hidden from user input)
                Forms\Components\TextInput::make('employee_number')
                    ->label(__('f28.employee_number'))
                    ->disabled()
                    ->placeholder(__('f28.manager_number_placeholder')),

                // Customer Number
                Forms\Components\TextInput::make('customer_number')
                    ->label(__('f28.customer_number'))
                    ->required()
                    ->maxLength(30),

                // Employee Name
                Forms\Components\TextInput::make('employee_name')
                    ->label(__('f28.employee_name'))
                    ->required()
                    ->maxLength(255),

                // Address
                Forms\Components\Textarea::make('address')
                    ->label(__('f28.address'))
                    ->nullable(),

                // Date of Birth
                Forms\Components\DatePicker::make('date_of_birth')
                    ->label(__('f28.date_of_birth'))
                    ->required(),

                // NIC Number
                Forms\Components\TextInput::make('nic_number')
                    ->label(__('f28.nic_number'))
                    ->required()
                    ->maxLength(12)
                    ->rules([
                        'regex:/^\d{12}$|^\d{9}[VvXx]$/i', // Validate 12 digits or 9 digits + 'V' or 'X'
                    ])
                    ->validationMessages([
                        'regex' => __('f28.nic_validate'),
                    ]),

                // ETF Number
                Forms\Components\TextInput::make('etf_number')
                    ->label(__('f28.etf_number'))
                    ->nullable()
                    ->maxLength(20),

                // Employee Type (Dropdown with data from ImportantParameterHelper)
                Forms\Components\Select::make('employee_type')
                    ->label(__('f28.employee_type'))
                    ->options(ImportantParameterHelper::getValues('employee_types')) // Get employee types from helper
                    ->required(),

                // Cashier (Checkbox)
                Forms\Components\Checkbox::make('cashier')
                    ->label(__('f28.cashier'))
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee_number')->label(__('f28.employee_number'))->sortable()->searchable(),
                TextColumn::make('customer_number')->label(__('f28.customer_number'))->sortable()->searchable(),
                TextColumn::make('employee_name')->label(__('f28.employee_name'))->sortable()->searchable(),
                ///TextColumn::make('address')->label(__('f28.address'))->limit(50), // Limit address length for display
                TextColumn::make('date_of_birth')->label(__('f28.date_of_birth'))->date(), // Format as date
                TextColumn::make('nic_number')->label(__('f28.nic_number'))->sortable()->searchable(),
                TextColumn::make('etf_number')->label(__('f28.etf_number'))->sortable()->searchable(),
                TextColumn::make('employee_type')
                    ->formatStateUsing(function ($state) {
                        // Fetch the label for the stored value from ImportantParameter
                        $employee_types = ImportantParameterHelper::getValues('employee_types');
                        return $employee_types[$state] ?? $state; // Return the label or the raw value if not found
                    })
                    ->label(__('f28.employee_type'))->sortable()->searchable(),
                BooleanColumn::make('cashier')->label(__('f28.cashier')),
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
            'index' => Pages\ListEmployees::route('/'),
        ];
    }
}
