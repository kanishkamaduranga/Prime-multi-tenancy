<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountSegmentResource\Pages;
use App\Filament\Resources\AccountSegmentResource\RelationManagers;
use App\Models\AccountSegment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Helpers\ImportantParameterHelper;

class AccountSegmentResource extends Resource
{
    protected static ?string $model = AccountSegment::class;
    protected static ?string $navigationGroup = 'Basic Notes';

    protected static ?string $navigationIcon = 'heroicon-o-document-currency-pound';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('department_id')
                    ->relationship('department', 'department') // Assuming 'name' is a field in the departments table
                    ->required()
                    ->label(__('f28.department')),

                Forms\Components\Select::make('basic_account')
                    ->options(ImportantParameterHelper::getValues('basic_accounts')) // Fetch options from ImportantParameter
                    ->required()
                    ->label(__('f28.basic_accounts')),

                Forms\Components\TextInput::make('account_number')
                    ->required()
                    ->maxLength(50)
                    ->label(__('f28.account_number')),

                Forms\Components\TextInput::make('account_name')
                    ->required()
                    ->maxLength(255)
                    ->label(__('f28.account_name')),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('department.department')
                    ->label(__('f28.department'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('basic_account')
                    ->label(__('f28.basic_accounts'))
                    ->formatStateUsing(function ($state) {
                        // Fetch the label for the stored value from ImportantParameter
                        $basicAccounts = ImportantParameterHelper::getValues('basic_accounts');
                        return $basicAccounts[$state] ?? $state; // Return the label or the raw value if not found
                    })
                    ->searchable(),

                Tables\Columns\TextColumn::make('account_number')
                    ->label(__('f28.account_number'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('account_name')
                    ->label(__('f28.account_name'))
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListAccountSegments::route('/'),
        ];
    }
}
