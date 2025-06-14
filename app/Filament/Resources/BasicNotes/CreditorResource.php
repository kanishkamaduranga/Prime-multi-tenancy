<?php

namespace App\Filament\Resources\BasicNotes;

use App\Filament\Resources\BasicNotes;
use App\Filament\Resources\BasicNotes\CreditorResource\Pages;
use App\Filament\Resources\BasicNotes\CreditorResource\RelationManagers;
use App\Models\Creditor;
use App\Models\LedgerController;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CreditorResource extends Resource
{
    protected static ?string $model = Creditor::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'basic_notes';

    protected static ?int $navigationSort = 3;

    public static function getModelLabel(): string
    {
        return trans('f28.Creditor');
    }

    public static function getNavigationLabel(): string
    {
        return trans('f28.Creditor_supplier');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('f28.Creditor_supplier');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Auto-generated creditors number (read-only)
                Forms\Components\TextInput::make('creditors_number')
                    //->default('SUPH' . str_pad(Creditor::max('id') + 1, 8, '0', STR_PAD_LEFT)) // Auto-generate default value
                    ->disabled() // Make it read-only
                    ->label(__('f28.creditors_number'))
                    ->placeholder(__('f28.creditors_number_placeholder')),

                Forms\Components\TextInput::make('customer_number')
                    ->required()
                    ->maxLength(20)
                    ->label(__('f28.customer_number')),

                Forms\Components\TextInput::make('creditor_name')
                    ->required()
                    ->maxLength(255)
                    ->label(__('f28.creditor_name')),

                Forms\Components\Textarea::make('address')
                    ->maxLength(500)
                    ->label(__('f28.address'))
                    ->nullable(),

                Forms\Components\TextInput::make('telephone_number')
                    ->required()
                    ->maxLength(20)
                    ->label(__('f28.telephone_number')),


                Forms\Components\Select::make('control_account_id')
                    ->label(__('f28.control_account_name'))
                    ->options(function () {
                        return LedgerController::where('type', 'control_account')
                            ->selectRaw("id, CONCAT(number, ' - ', name) as account_full")
                            ->pluck('account_full', 'id');
                    })
                    ->searchable()
                    ->required(),


                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->label(__('f28.price')),

                Forms\Components\TextInput::make('year')
                    ->required()
                    ->numeric()
                    ->default(date('Y'))
                    ->maxLength(4)
                    ->minLength(4)
                    ->label(__('f28.year')),

                Forms\Components\TextInput::make('month')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(12)
                    ->default(date('m'))
                    ->label(__('f28.month')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('creditors_number')
                    ->label(__('f28.customer_number'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('customer_number')
                    ->label(__('f28.customer_number'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('creditor_name')
                    ->label(__('f28.creditor_name'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('address')
                    ->label(__('f28.address'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('telephone_number')
                    ->label(__('f28.telephone_number'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('controlAccount.name')
                    ->label(__('f28.control_account_name'))
                    ->formatStateUsing(fn ($state, $record) =>
                        $record->controlAccount->number . ' - ' . $state
                    )
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
            'index' => BasicNotes\CreditorResource\Pages\ListCreditors::route('/'),
        ];
    }
}
