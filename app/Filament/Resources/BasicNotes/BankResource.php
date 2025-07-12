<?php

namespace App\Filament\Resources\BasicNotes;

use App\Filament\Resources\BasicNotes\BankResource\Pages;
use App\Filament\Resources\BasicNotes\BankResource\RelationManagers;
use App\Filament\Resources\BasicNotes;
use App\Models\Bank;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BankResource extends Resource
{

    public static function canViewAny(): bool
    {
        return auth()->user()->can('Banks_view');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('Banks_create');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->can('Banks_edit');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->can('Banks_delete');
    }


    protected static ?string $model = Bank::class;

    protected static ?string $navigationGroup = 'basic_notes'; // Group under "basic_notes"
    protected static ?string $navigationIcon = 'heroicon-o-banknotes'; // Icon for the resource

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return trans('f28.Bank');
    }

    public static function getNavigationLabel(): string
    {
        return trans('f28.Bank');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('f28.Bank');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('bank_code')
                    ->label(__('f28.bank_code'))
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('bank')
                    ->label(__('f28.bank_name'))
                    ->required()
                    ->maxLength(150),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('bank_code')
                    ->label(__('f28.bank_code'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('bank')
                    ->label(__('f28.bank_name'))
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modal(),
                Tables\Actions\DeleteAction::make(), // Add delete action
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
            'index' => BasicNotes\BankResource\Pages\ListBanks::route('/'),
        ];
    }
}
