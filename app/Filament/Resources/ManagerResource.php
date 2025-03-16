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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Manager Number (auto-generated, hidden from user input)
                Forms\Components\TextInput::make('manager_number')
                    ->label('Manager Number')
                    ->disabled()
                    ->placeholder(__('f28.manager_number_placeholder')),

                // Manager Name
                Forms\Components\TextInput::make('manager_name')
                    ->label('Manager Name')
                    ->required(),

                // Control Account (FK to control_accounts)
                Forms\Components\Select::make('control_account_id')
                    ->label('Control Account')
                    ->relationship('controlAccount', 'account_name') // Assuming 'name' is a field in control_accounts
                   // ->searchable()
                    ->required(),

                // Department (FK to departments)
                Forms\Components\Select::make('department_id')
                    ->label('Department')
                    ->relationship('department', 'department') // Assuming 'name' is a field in departments
                    //->searchable()
                    ->required(),

                // Branch Type (FK to branch_types)
                Forms\Components\Select::make('branch_type_id')
                    ->label('Branch Type')
                    ->relationship('branchType', 'branch_type_name') // Assuming 'name' is a field in branch_types
                   // ->searchable()
                    ->required(),

                // Branches (Many-to-Many with branches)
                Forms\Components\Select::make('branches')
                    ->label('Branches')
                    ->relationship('branches', 'branch_name') // Assuming 'name' is a field in branches
                    ->multiple()
                    ->searchable()
                    ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('manager_number')->label('Manager Number')->sortable()->searchable(),
                TextColumn::make('manager_name')->label('Manager Name')->sortable()->searchable(),
                TextColumn::make('controlAccount.account_name')->label('Control Account')->sortable()->searchable(),
                TextColumn::make('department.department')->label('Department')->sortable()->searchable(),
                TextColumn::make('branchType.branch_type_name')->label('Branch Type')->sortable()->searchable(),
               // TextColumn::make('branches.branch_name')->label('Branches')->sortable()->searchable(),
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
