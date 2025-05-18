<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConfigurationFormLedgerResource\Pages;
use App\Filament\Resources\ConfigurationFormLedgerResource\RelationManagers;
use App\Models\ConfigurationFormLedger;
use App\Models\Department;
use App\Models\Ledger;
use App\Helpers\ImportantParameterHelper;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ConfigurationFormLedgerResource extends Resource
{
    protected static ?string $model = ConfigurationFormLedger::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?string $navigationGroup = 'user';
    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return trans('f28.configuration_form_ledger');
    }

    public static function getNavigationLabel(): string
    {
        return trans('f28.configuration_form_ledger');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('f28.configuration_form_ledger');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
                        Forms\Components\Select::make('configuration_type')
                            ->label(__('f28.configuration_type'))
                            ->options(ImportantParameterHelper::getValues('configuration_forms_ledgers'))
                            ->required()
                            ->searchable(),

                        Forms\Components\Select::make('department_id')
                            ->label(__('f28.department'))
                            ->options(Department::pluck('department', 'id'))
                            ->required()
                            ->searchable(),

                        Forms\Components\Select::make('debit_ledger_id')
                            ->label(__('f28.debit'))
                            ->options(function () {
                                return Ledger::query()
                                    ->selectRaw("id, CONCAT(ledger_number, ' - ', ledger_name) as ledger_full")
                                    ->pluck('ledger_full', 'id');
                            })
                            ->required()
                            ->searchable(),

                        Forms\Components\Select::make('credit_ledger_id')
                            ->label(__('f28.credit'))
                            ->options(function () {
                                return Ledger::query()
                                    ->selectRaw("id, CONCAT(ledger_number, ' - ', ledger_name) as ledger_full")
                                    ->pluck('ledger_full', 'id');
                            })
                            ->required()
                            ->searchable(),
                    ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('configuration_type')
                    ->label(__('f28.configuration_type'))
                    ->searchable()
                    ->formatStateUsing(function ($state) {
                        // Fetch the label for the stored value from ImportantParameterHelper
                        $configuration_forms_ledgers = ImportantParameterHelper::getValues('configuration_forms_ledgers');
                        return $configuration_forms_ledgers[$state] ?? $state; // Return the label or the raw value if not found
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('department.department')
                    ->label(__('f28.department'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('debitLedger.ledger_number')
                    ->label(__('f28.debit'))
                    ->formatStateUsing(fn ($state, $record) =>
                        $state . ' - ' . $record->debitLedger->ledger_name
                    )
                    ->searchable(),

                Tables\Columns\TextColumn::make('creditLedger.ledger_number')
                    ->label(__('f28.credit'))
                    ->formatStateUsing(fn ($state, $record) =>
                        $state . ' - ' . $record->creditLedger->ledger_name
                    )
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('configuration_type')
                    ->options(ImportantParameterHelper::getValues('configuration_forms_ledgers'))
                    ->label('Configuration Type'),

                Tables\Filters\SelectFilter::make('department_id')
                    ->label('Department')
                    ->options(Department::pluck('department', 'id'))
                    ->searchable(),
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
            // Add relation managers if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListConfigurationFormLedgers::route('/'),
        ];
    }
}
