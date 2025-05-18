<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubAccountSegmentResource\Pages;
use App\Filament\Resources\SubAccountSegmentResource\RelationManagers;
use App\Helpers\ImportantParameterHelper;
use App\Models\SubAccountSegment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubAccountSegmentResource extends Resource
{
    protected static ?string $model = SubAccountSegment::class;

    protected static ?string $navigationGroup = 'Basic Notes';

    protected static ?string $navigationIcon = 'heroicon-o-document-currency-rupee';

    protected static ?int $navigationSort = 9;

    public static function getModelLabel(): string
    {
        return trans('f28.sub_account_segments');
    }

    public static function getNavigationLabel(): string
    {
        return trans('f28.sub_account_segments');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('f28.sub_account_segments');
    }

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

                Forms\Components\Select::make('account_segment_id')
                    ->relationship('accountSegment', 'account_name') // Assuming 'account_name' is a field in the account_segments table
                    ->required()
                    ->label(__('f28.account_name')),

                Forms\Components\TextInput::make('sub_account_number')
                    ->required()
                    ->maxLength(50)
                    ->label(__('f28.sub_account_number')),

                Forms\Components\TextInput::make('sub_account_name')
                    ->required()
                    ->maxLength(255)
                    ->label(__('f28.sub_account_name')),

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

                Tables\Columns\TextColumn::make('accountSegment.account_name')
                    ->label(__('f28.account_name'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('sub_account_number')
                    ->label(__('f28.sub_account_number'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('sub_account_name')
                    ->label(__('f28.sub_account_name'))
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
            'index' => Pages\ListSubAccountSegments::route('/'),
        ];
    }
}
