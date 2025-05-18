<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ManagerResource\Pages;
use App\Filament\Resources\ManagerResource\RelationManagers;
use App\Models\Manager;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;


class ManagerResource extends Resource
{
    protected static ?string $model = Manager::class;

    protected static ?string $navigationGroup = 'Basic Notes';

    protected static ?string $navigationIcon = 'heroicon-o-cog-8-tooth';

    protected static ?int $navigationSort = 15;

    public static function getModelLabel(): string
    {
        return trans('f28.Managers');
    }

    public static function getNavigationLabel(): string
    {
        return trans('f28.Managers');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('f28.Managers');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Manager Number (auto-generated, hidden from user input)
                Forms\Components\TextInput::make('manager_number')
                    ->label(__('f28.manager_number'))
                    ->disabled()
                    ->placeholder(__('f28.manager_number_placeholder')),

                // Manager Name
                Forms\Components\TextInput::make('manager_name')
                    ->label(__('f28.manager_name'))
                    ->required(),

                // Control Account (FK to control_accounts)
                Forms\Components\Select::make('control_account_id')
                    ->label(__('f28.control_account'))
                    ->relationship('controlAccount', 'account_name') // Assuming 'name' is a field in control_accounts
                   // ->searchable()
                    ->required(),

                // Department (FK to departments)
                Forms\Components\Select::make('department_id')
                    ->label(__('f28.department'))
                    ->relationship('department', 'department') // Assuming 'name' is a field in departments
                    //->searchable()
                    ->required(),

                // Branch Type (FK to branch_types)
                Forms\Components\Select::make('branch_type_id')
                    ->label(__('f28.branch_type'))
                    ->relationship('branchType', 'branch_type_name') // Assuming 'name' is a field in branch_types
                   // ->searchable()
                    ->required(),

                // Branches (Many-to-Many with branches)
                Forms\Components\Select::make('branches')
                    ->label(__('f28.Branch'))
                    ->relationship('branches', 'branch_name') // Assuming 'name' is a field in branches
                    ->multiple()
                    ->searchable()
                    ->preload(),

                Forms\Components\Select::make('status')
                    ->label(__('f28.status'))
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'suspended' => 'Suspended',
                    ])
                    ->default('active') // Default value
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('manager_number')->label(__('f28.manager_number'))->sortable()->searchable(),
                TextColumn::make('manager_name')->label(__('f28.manager_name'))->sortable()->searchable(),
                TextColumn::make('controlAccount.account_name')->label(__('f28.control_account'))->sortable()->searchable(),
                TextColumn::make('department.department')->label(__('f28.department'))->sortable()->searchable(),
                TextColumn::make('branchType.branch_type_name')->label(__('f28.branch_type'))->sortable()->searchable(),
               // TextColumn::make('branches.branch_name')->label('Branches')->sortable()->searchable(),
                TextColumn::make('status')->label(__('f28.status'))->sortable()->searchable(),
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
            'index' => Pages\ListManagers::route('/'),
        ];
    }
}
