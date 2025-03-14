<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepartmentCategoryResource\Pages;
use App\Filament\Resources\DepartmentCategoryResource\RelationManagers;
use App\Models\DepartmentCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Department;
class DepartmentCategoryResource extends Resource
{
    protected static ?string $model = DepartmentCategory::class;

    protected static ?string $navigationGroup = 'Basic Notes'; // Group under "Basic Notes"
    protected static ?string $navigationLabel = 'Departments Category'; // Sub-link label
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(components: [
                Forms\Components\Select::make('department_id')
                    ->label('Department')
                    ->options(Department::all()->pluck('department', 'id')) // Fetch departments and map id to name
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('department_category_number')
                    ->label('Category Number')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('department_category_name')
                    ->label('Category Name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('department_category_number')
                    ->label('Category Code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('department_category_name')
                    ->label('Category Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('department.department_code') // Department code from relationship
                ->label('Department Code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('department.department') // Department name from relationship
                ->label('Department Name')
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
            'index' => Pages\ListDepartmentCategories::route('/'),
        ];
    }
}
