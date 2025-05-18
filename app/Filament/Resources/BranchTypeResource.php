<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BranchTypeResource\Pages;
use App\Filament\Resources\BranchTypeResource\RelationManagers;
use App\Models\BranchType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BranchTypeResource extends Resource
{
    protected static ?string $model = BranchType::class;

    protected static ?string $navigationGroup = 'Basic Notes'; // Group under "Basic Notes"
    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?int $navigationSort = 6;

    public static function getModelLabel(): string
    {
        return trans('f28.Branch_type');
    }

    public static function getNavigationLabel(): string
    {
        return trans('f28.Branch_type');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('f28.Branch_type');
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('department_id')
                    ->relationship('department', 'department') // Assuming 'name' is a field in the departments table
                    ->required()
                    ->label(__('f28.department')),
                Forms\Components\TextInput::make('branch_type_number')
                    ->required()
                    ->maxLength(20)
                    ->label(__('f28.branch_type_number')),
                Forms\Components\TextInput::make('branch_type_name')
                    ->required()
                    ->maxLength(255)
                    ->label(__('f28.branch_type_name')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('branch_type_number')
                    ->label(__('f28.branch_type_number'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('branch_type_name')
                    ->label(__('f28.branch_type_name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('department.department_code')
                    ->label(__('f28.department_code'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('department.department')
                    ->label(__('f28.department'))
                    ->sortable(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBranchTypes::route('/'),
        ];
    }
}
