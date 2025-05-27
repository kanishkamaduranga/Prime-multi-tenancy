<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DebtorResource\Pages;
use App\Filament\Resources\DebtorResource\RelationManagers;
use App\Models\Debtor;
use App\Models\LedgerController;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
class DebtorResource extends Resource
{
    protected static ?string $model = Debtor::class;
    protected static ?string $navigationGroup = 'basic_notes';
    protected static ?int $navigationSort = 17;


    public static function getModelLabel(): string
    {
        return trans('f28.Debtors_consumers');
    }

    public static function getNavigationLabel(): string
    {
        return trans('f28.Debtors_consumers');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('f28.Debtors_consumers');
    }

    protected static ?string $navigationIcon = 'heroicon-o-currency-yen';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Debtor Number (auto-generated, hidden from user input)
                Forms\Components\TextInput::make('debtor_number')
                    ->label(__('f28.debtor_number'))
                    ->disabled()
                    ->placeholder(__('f28.debtor_number_placeholder')),

                // Customer Number
                Forms\Components\TextInput::make('customer_number')
                    ->label(__('f28.customer_number'))
                    ->required()
                    ->maxLength(20),

                // Debtor Name
                Forms\Components\TextInput::make('debtor_name')
                    ->label(__('f28.debtor_name'))
                    ->required()
                    ->maxLength(255),

                // Address
                Forms\Components\Textarea::make('address')
                    ->label(__('f28.address'))
                    ->nullable(),

                // Telephone Number
                Forms\Components\TextInput::make('telephone_number')
                    ->label(__('f28.telephone_number'))
                    ->nullable()
                    ->maxLength(20),

                // Control Account (FK to control_accounts)
                Forms\Components\Select::make('control_account_id')
                    ->label(__('f28.control_account_name'))
                    ->options(function () {
                        return LedgerController::where('type', 'control_account')
                            ->selectRaw("id, CONCAT(number, ' - ', name) as account_full")
                            ->pluck('account_full', 'id');
                    })
                    ->searchable()
                    ->required(),

                // Saved Amount
                Forms\Components\TextInput::make('saved_amount')
                    ->label(__('f28.saved_amount'))
                    ->numeric()
                    ->default(0)
                    ->required(),

                // Date
                Forms\Components\DatePicker::make('date')
                    ->label(__('f28.date'))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('debtor_number')->label(__('f28.debtor_number'))->sortable()->searchable(),
                TextColumn::make('customer_number')->label(__('f28.customer_number'))->sortable()->searchable(),
                TextColumn::make('debtor_name')->label(__('f28.debtor_name'))->sortable()->searchable(),
                TextColumn::make('address')->label(__('f28.address'))->limit(50), // Limit address length for display
                TextColumn::make('telephone_number')->label(__('f28.telephone_number'))->sortable()->searchable(),
                TextColumn::make('controlAccount.name')
                    ->label(__('f28.control_account_name'))
                    ->formatStateUsing(fn ($state, $record) =>
                        $record->controlAccount->number . ' - ' . $state
                    )
                    ->sortable()
                    ->searchable(),
                TextColumn::make('saved_amount')->label(__('f28.saved_amount'))->sortable()->money('LKR'), // Format as currency
                TextColumn::make('date')->label(__('f28.date'))->date(), // Format as date
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
            'index' => Pages\ListDebtors::route('/'),
        ];
    }
}
