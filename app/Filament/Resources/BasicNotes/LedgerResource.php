<?php

namespace App\Filament\Resources\BasicNotes;

use App\Filament\Resources\BasicNotes;
use App\Filament\Resources\BasicNotes\LedgerResource\Pages;
use App\Filament\Resources\BasicNotes\LedgerResource\RelationManagers;
use App\Helpers\ImportantParameterHelper;
use App\Models\LedgerController;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LedgerResource extends Resource
{
    protected static ?string $model = LedgerController::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'basic_notes';
    protected static ?int $navigationSort = 10;

    public static function getModelLabel(): string
    {
        return trans('f28.Ledger');
    }

    public static function getNavigationLabel(): string
    {
        return trans('f28.Ledger');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('f28.Ledger');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('type', 'ledger');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('department_id')
                    ->relationship('department', 'department')
                    ->required()
                    ->live()
                    ->label(__('f28.department'))
                    ->afterStateUpdated(fn (Forms\Set $set) => $set('account_segment_id', null)),

                Forms\Components\Select::make('basic_account')
                    ->options(ImportantParameterHelper::getValues('basic_accounts'))
                    ->required()
                    ->live()
                    ->label(__('f28.basic_accounts'))
                    ->afterStateUpdated(fn (Forms\Set $set) => $set('account_segment_id', null)),

                Forms\Components\Select::make('account_segment_id')
                    ->options(function (Forms\Get $get) {
                        return \App\Models\AccountSegment::query()
                            ->where('department_id', $get('department_id'))
                            ->where('basic_account', $get('basic_account'))
                            ->pluck('account_name', 'id');
                    })
                    ->required()
                    ->live()
                    ->label(__('f28.account_segments'))
                    ->afterStateUpdated(fn (Forms\Set $set) => $set('sub_account_segment_id', null)),

                Forms\Components\Select::make('sub_account_segment_id')
                    ->options(function (Forms\Get $get) {
                        return \App\Models\SubAccountSegment::query()
                            ->where('account_segment_id', $get('account_segment_id'))
                            ->pluck('sub_account_name', 'id');
                    })
                    ->required()
                    ->live()
                    ->label(__('f28.sub_account_segments'))
                    ->afterStateUpdated(fn (Forms\Set $set) => $set('control_account_id', null)),

                Forms\Components\TextInput::make('number')
                    ->required()
                    ->maxLength(50)
                    ->label(__('f28.ledger_number')),

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label(__('f28.ledger_name')),

                Forms\Components\Select::make('control_account_id')
                    ->options(function (Forms\Get $get) {
                        return \App\Models\LedgerController::query()
                            ->where('type', 'control_account')
                            ->where('sub_account_segment_id', $get('sub_account_segment_id'))
                            ->pluck('name', 'id');
                    })
                    ->label(__('f28.control_account_name')),

                Forms\Components\CheckboxList::make('basic_ledger')
                    ->options(ImportantParameterHelper::getValues('basic_ledger'))
                    ->columns(1)
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
                        $basicAccounts = ImportantParameterHelper::getValues('basic_accounts');
                        return $basicAccounts[$state] ?? $state;
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

                Tables\Columns\TextColumn::make('number')
                    ->label(__('f28.ledger_number'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('f28.ledger_name'))
                    ->searchable(),

                Tables\Columns\IconColumn::make('f8_number')
                    ->label(__('f28.f8_number'))
                    ->boolean(),
            ])
            ->filters([
                // Add any additional filters you need
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
            // Add any relations you need
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => BasicNotes\LedgerResource\Pages\ListLedgers::route('/'),
        ];
    }
}
