<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ControlAccountResource\Pages;
use App\Filament\Resources\ControlAccountResource\RelationManagers;
use App\Models\LedgerController;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Helpers\ImportantParameterHelper;

class ControlAccountResource extends Resource
{
    protected static ?string $model = LedgerController::class;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';

    protected static ?string $navigationGroup = 'basic_notes';
    protected static ?int $navigationSort = 16;

    public static function getModelLabel(): string
    {
        return trans('f28.control_account');
    }

    public static function getNavigationLabel(): string
    {
        return trans('f28.control_account');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('f28.control_account');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('type', 'control_account');
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
                    ->label(__('f28.sub_account_segments')),

                Forms\Components\TextInput::make('number')
                    ->required()
                    ->maxLength(50)
                    ->label(__('f28.account_number')),

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label(__('f28.account_name')),

                Forms\Components\CheckboxList::make('basic_ledger')
                    ->options(ImportantParameterHelper::getValues('basic_ledger'))
                    ->columns(1)
                    ->label(__('f28.basic_ledger')),
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
                    ->label(__('f28.account_number'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('f28.account_name'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('basic_ledger')
                    ->label(__('f28.basic_ledger'))
                    ->formatStateUsing(function ($state) {
                        $basicLedgers = ImportantParameterHelper::getValues('basic_ledger');
                        return collect($state)->map(fn ($value) => $basicLedgers[$value] ?? $value)->implode(', ');
                    }),
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
            RelationManagers\LedgersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListControlAccounts::route('/'),
        ];
    }
}
