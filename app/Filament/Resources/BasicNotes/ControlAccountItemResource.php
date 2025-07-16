<?php

namespace App\Filament\Resources\BasicNotes;

use App\Filament\Resources\BasicNotes;
use App\Filament\Resources\BasicNotes\ControlAccountItemResource\Pages;
use App\Filament\Resources\BasicNotes\ControlAccountItemResource\RelationManagers;
use App\Models\ControlAccountItem;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\LedgerController;
use App\Helpers\ImportantParameterHelper;
use Filament\Forms;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ControlAccountItemResource extends Resource
{
    public static function canViewAny(): bool
    {
        return auth()->user()->can('Control_Account_Item_view');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('Control_Account_Item_view_create');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->can('Control_Account_Item_view_edit');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->can('Control_Account_Item_view_delete');
    }


    protected static ?string $model = ControlAccountItem::class;
    protected static ?string $navigationGroup = 'basic_notes'; // Group under "basic_notes"
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 18;

    public static function getModelLabel(): string
    {
        return trans('f28.control_account_item_add');
    }

    public static function getNavigationLabel(): string
    {
        return trans('f28.control_account_item_add');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('f28.control_account_item_add');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('ledger_control_account_id')
                    ->label(__('f28.control_account'))
                    ->options(LedgerController::where('type', 'control_account')->pluck('name', 'id'))
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('item_type')
                    ->label(__('f28.item_type'))
                    ->options(ImportantParameterHelper::getValues('items_for_control_accounts'))
                    ->searchable()
                    ->required(),

                Forms\Components\TextInput::make('item_number')
                    ->label(__('f28.item_number'))
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('note')
                    ->label(__('f28.note'))
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('controlAccount.name')
                    ->label(__('f28.control_account'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('item_type')
                    ->label(__('f28.item_type'))
                    ->formatStateUsing(function ($state) {
                        // Fetch the label for the stored value from ImportantParameter
                        $basicAccounts = ImportantParameterHelper::getValues('items_for_control_accounts');
                        return $basicAccounts[$state] ?? $state; // Return the label or the raw value if not found
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('item_number')
                    ->label(__('f28.item_number'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('note')
                    ->label(__('f28.note'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->modal(),
                Tables\Actions\EditAction::make()->modal(),
                Tables\Actions\DeleteAction::make(), // Delete action
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
            'index' => BasicNotes\ControlAccountItemResource\Pages\ListControlAccountItems::route('/'),
        ];
    }
}
