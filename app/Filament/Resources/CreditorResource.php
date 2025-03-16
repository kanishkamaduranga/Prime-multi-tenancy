<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CreditorResource\Pages;
use App\Filament\Resources\CreditorResource\RelationManagers;
use App\Models\Creditor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CreditorResource extends Resource
{
    protected static ?string $model = Creditor::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Basic Notes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Auto-generated creditors number (read-only)
                Forms\Components\TextInput::make('creditors_number')
                    ->default('SUPH' . str_pad(Creditor::max('id') + 1, 8, '0', STR_PAD_LEFT)) // Auto-generate default value
                    ->disabled() // Make it read-only
                    ->label(__('f28.creditors_number')),

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
                    ->relationship('controlAccount', 'account_name') // Assuming 'account_name' is a field in the control_accounts table
                    ->required()
                   // ->searchable() // Enable search for dropdown
                    ->label(__('f28.control_account_name')),

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

                Tables\Columns\TextColumn::make('controlAccount.account_name')
                    ->label(__('f28.control_account_name'))
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
            'index' => Pages\ListCreditors::route('/'),
        ];
    }
}
