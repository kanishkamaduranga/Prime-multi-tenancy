<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BankAccountResource\Pages;
use App\Filament\Resources\BankAccountResource\RelationManagers;
use App\Models\BankAccount;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Helpers\ImportantParameterHelper;

class BankAccountResource extends Resource
{
    protected static ?string $model = BankAccount::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Basic Notes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([


                Forms\Components\Select::make('bank_id')
                    ->relationship('bank', 'bank') // Assuming 'name' is a field in the banks table
                    ->required()
                    //->searchable() // Enable search for dropdown
                   ->label(__('f28.bank_name')),

                Forms\Components\TextInput::make('bank_account_number')
                    ->required()
                    ->maxLength(50)
                    ->label(__('f28.bank_account_number')),

                Forms\Components\TextInput::make('bank_account_name')
                    ->required()
                    ->maxLength(255)
                    ->label(__('f28.bank_account_name')),

                Forms\Components\DatePicker::make('balance_start_date')
                    ->required()
                    ->label(__('f28.balance_start_date')),

                Forms\Components\TextInput::make('start_balance')
                    ->required()
                    ->numeric()
                    ->label(__('f28.start_balance')),

                Forms\Components\Select::make('debit_or_credit')
                    ->options([
                        'debit' => 'Debit',
                        'credit' => 'Credit',
                    ])
                    ->required()
                    ->label(__('f28.debit_or_credit')),

                Forms\Components\Placeholder::make('special_message')
                    ->content(__('f28.bank_account_special_message')) // Hardcoded message
                    ->label('')
                    ->columnSpanFull(),

                Forms\Components\Select::make('department_id')
                    ->relationship('department', 'department') // Assuming 'name' is a field in the departments table
                    ->required()
                    ->live() // Enable live updates
                   // ->searchable() // Enable search for dropdown
                    ->label(__('f28.department'))
                    ->afterStateUpdated(fn (Forms\Set $set) => $set('account_segment_id', null)), // Reset account segment when department changes

                Forms\Components\Select::make('basic_account')
                    ->options(ImportantParameterHelper::getValues('basic_accounts')) // Fetch options from ImportantParameterHelper
                    ->required()
                    ->live() // Enable live updates
                    ->searchable() // Enable search for dropdown
                    ->label(__('f28.basic_accounts'))
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
                    ->searchable() // Enable search for dropdown
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
                    ->live() // Enable live updates
                    ->searchable() // Enable search for dropdown
                    ->label(__('f28.sub_account_segments'))
                    ->afterStateUpdated(fn (Forms\Set $set) => $set('ledger_id', null)), // Reset ledger when sub-account segment changes

                Forms\Components\Select::make('ledger_id')
                    ->options(function (Forms\Get $get) {
                        // Load ledgers filtered by sub-account segment
                        return \App\Models\Ledger::query()
                            ->where('sub_account_segment_id', $get('sub_account_segment_id'))
                            ->pluck('ledger_name', 'id');
                    })
                    ->required()
                    ->searchable() // Enable search for dropdown
                    ->label(__('f28.ledger_name')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('bank.bank')
                    ->label(__('f28.bank_name'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('bank_account_number')
                    ->label(__('f28.bank_account_number'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('bank_account_name')
                    ->label(__('f28.bank_account_name'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('balance_start_date')
                    ->label(__('f28.balance_start_date'))
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('start_balance')
                    ->label(__('f28.start_balance'))
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('debit_or_credit')
                    ->label(__('f28.debit_or_credit'))
                    ->sortable(),

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

                Tables\Columns\TextColumn::make('ledger.ledger_name')
                    ->label(__('f28.ledger_name'))
                    ->sortable()
                    ->searchable(),
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
            'index' => Pages\ListBankAccounts::route('/'),
        ];
    }
}
