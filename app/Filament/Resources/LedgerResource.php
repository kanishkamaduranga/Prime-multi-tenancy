<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LedgerResource\Pages;
use App\Filament\Resources\LedgerResource\RelationManagers;
use App\Models\Ledger;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Helpers\ImportantParameterHelper;

class LedgerResource extends Resource
{
    protected static ?string $model = Ledger::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'basic_notes';
    protected static ?int $navigationSort = 10;

    public static function getModelLabel(): string
    {
        return trans('f28.Ledger');
    }

    public static function getNavigationLabeLedger(): string
    {
        return trans('f28.Ledger');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('f28.Ledger');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('department_id')
                    ->relationship('department', 'department') // Assuming 'name' is a field in the departments table
                    ->required()
                    ->live() // Enable live updates
                    ->label(__('f28.department'))
                    ->afterStateUpdated(fn (Forms\Set $set) => $set('account_segment_id', null)), // Reset account segment when department changes

                Forms\Components\Select::make('basic_account')
                    ->options(ImportantParameterHelper::getValues('basic_accounts')) // Fetch options from ImportantParameterHelper
                    ->required()
                    ->live() // Enable live updates
                    ->label(__('f28.bank_account'))
                    ->afterStateUpdated(fn (Forms\Set $set) => $set('account_segment_id', null)), // Reset account segment when basic account changes

                Forms\Components\Select::make('account_segment_id')
                    ->options(function (Forms\Get $get) {
                        // Load account segments filtered by department and basic account
                        return \App\Models\AccountSegment::query()
                            ->where('department_id', $get('department_id'))
                            ->where('basic_account', $get('basic_account'))
                            ->pluck('account_name', 'id');
                    })
                    ->required()
                    ->live() // Enable live updates
                    ->label(__('f28.account_segments'))
                    ->afterStateUpdated(fn (Forms\Set $set) => $set('sub_account_segment_id', null)), // Reset sub-account segment when account segment changes

                Forms\Components\Select::make('sub_account_segment_id')
                    ->options(function (Forms\Get $get) {
                        // Load sub-account segments filtered by account segment
                        return \App\Models\SubAccountSegment::query()
                            ->where('account_segment_id', $get('account_segment_id'))
                            ->pluck('sub_account_name', 'id');
                    })
                    ->required()
                    ->live()
                    ->label(__('f28.sub_account_segments'))
                    ->afterStateUpdated(fn (Forms\Set $set) => $set('control_account_id', null)),

                Forms\Components\TextInput::make('ledger_number')
                    ->required()
                    ->maxLength(50)
                    ->label(__('f28.ledger_number')),

                Forms\Components\TextInput::make('ledger_name')
                    ->required()
                    ->maxLength(255)
                    ->label(__('f28.ledger_name')),

                Forms\Components\Select::make('control_account_id')
                    ->options(function (Forms\Get $get) {
                        // Load control accounts filtered by sub-account segment
                        return \App\Models\ControlAccount::query()
                            ->where('sub_account_segment_id', $get('sub_account_segment_id'))
                            ->pluck('account_name', 'id');
                    })
                    ->label(__('f28.control_account_name')),

                Forms\Components\CheckboxList::make('basic_ledger')
                    ->options(ImportantParameterHelper::getValues('basic_ledger')) // Fetch options from ImportantParameterHelper
                    ->columns(1) // Display options in 3 columns
                    ->label(__('f28.basic_ledger')),

                Forms\Components\Toggle::make('f8_number')
                    ->default(false)
                    ->label(__('f28.f8_number')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('department.department')
                    ->label(__('f28.department'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('basic_account')
                    ->label(__('f28.basic_accounts'))
                    ->formatStateUsing(function ($state) {
                        // Fetch the label for the stored value from ImportantParameterHelper
                        $basicAccounts = ImportantParameterHelper::getValues('basic_accounts');
                        return $basicAccounts[$state] ?? $state; // Return the label or the raw value if not found
                    })
                    ->searchable(),

                Tables\Columns\TextColumn::make('accountSegment.account_name')
                    ->label(__('f28.account_segments'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('subAccountSegment.sub_account_name')
                    ->label(__('f28.sub_account_segments'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('ledger_number')
                    ->label(__('f28.ledger_number'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('ledger_name')
                    ->label(__('f28.ledger_name'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('controlAccount.account_name')
                    ->label(__('f28.control_account_name'))
                    ->sortable()
                    ->searchable(),

                /*Tables\Columns\TextColumn::make('basic_ledger')
                    ->label('Basic Ledger')
                    ->formatStateUsing(function ($state) {
                        // Fetch the labels for the stored values from ImportantParameterHelper
                        $basicLedger = ImportantParameterHelper::getValues('basic_ledger');
                        return collect($state)->map(fn ($value) => $basicLedger[$value] ?? $value)->implode(', ');
                    }),

                Tables\Columns\IconColumn::make('f8_number')
                    ->label('F8 Number')
                    ->boolean(),*/
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
            'index' => Pages\ListLedgers::route('/'),
        ];
    }
}
