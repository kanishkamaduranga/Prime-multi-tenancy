<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BranchResource\Pages;
use App\Filament\Resources\BranchResource\RelationManagers;
use App\Models\Branch;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BranchResource extends Resource
{
    protected static ?string $model = Branch::class;

    protected static ?string $navigationGroup = 'Basic Notes'; // Group under "Basic Notes"
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?int $navigationSort = 7;

    public static function getModelLabel(): string
    {
        return trans('f28.Branch');
    }

    public static function getNavigationLabel(): string
    {
        return trans('f28.Branch');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('f28.Branch');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('department_id')
                    ->relationship('department', 'department') // Assuming 'name' is a field in the departments table
                    ->required()
                    ->live()
                    ->label(__('f28.department'))
                    ->afterStateUpdated(fn (Forms\Set $set) => $set('branch_type_id', null)),

                Forms\Components\Select::make('region_id')
                    ->relationship('region', 'p_name') // Assuming 'name' is a field in the regions table
                    ->required()
                    ->label(__('f28.region')),

                Forms\Components\Select::make('branch_type_id')
                    ->options(function (Forms\Get $get) {
                        // Load branch types filtered by the selected department
                        return \App\Models\BranchType::query()
                            ->where('department_id', $get('department_id'))
                            ->pluck('branch_type_name', 'id');
                    })
                    ->required()
                    ->label(__('f28.branch_type_name')),
                Forms\Components\TextInput::make('branch_code')
                    ->required()
                    ->maxLength(20)
                    ->label(__('f28.branch_code')),
                Forms\Components\TextInput::make('branch_name')
                    ->required()
                    ->maxLength(255)
                    ->label(__('f28.branch_name')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('department.department')
                    ->label(__('f28.department'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('region.p_name')
                    ->label(__('f28.region'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('branchType.branch_type_name')
                    ->label(__('f28.branch_type_name'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('branch_code')
                    ->label(__('f28.branch_code'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('branch_name')
                    ->label(__('f28.branch_name'))
                    ->searchable(),
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


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBranches::route('/'),
        ];
    }
}
