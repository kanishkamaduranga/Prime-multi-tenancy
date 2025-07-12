<?php

namespace App\Filament\Resources\BasicNotes;

use App\Filament\Resources\BasicNotes;
use App\Filament\Resources\BasicNotes\DeratmentResource\Pages;
use App\Filament\Resources\BasicNotes\DeratmentResource\RelationManagers;
use App\Models\Department;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DeratmentResource extends Resource
{
    public static function canViewAny(): bool
    {
        return auth()->user()->can('Departments_view');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('Departments_create');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->can('Departments_edit');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->can('Departments_delete');
    }

    protected static ?string $model = Department::class;

    protected static ?string $navigationGroup = 'basic_notes'; // Group under "basic_notes"
    protected static ?string $navigationLabel = 'Departments'; // Sub-link label
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 4;

    public static function getModelLabel(): string
    {
        return trans('f28.Departments');
    }

    public static function getNavigationLabel(): string
    {
        return trans('f28.Departments');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('f28.Departments');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('department_code')
                    ->label(__('f28.department_code'))
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('department')
                    ->label(__('f28.department'))
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('department_code')
                    ->label(__('f28.department_code'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('department')
                    ->label(__('f28.department'))
                    ->searchable(),
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
            'index' => BasicNotes\DeratmentResource\Pages\ListDeratments::route('/'),
        ];
    }
}
