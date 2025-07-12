<?php

namespace App\Filament\Resources\BasicNotes;

use App\Filament\Resources\BasicNotes;
use App\Filament\Resources\BasicNotes\RegionResource\Pages;
use App\Filament\Resources\BasicNotes\RegionResource\RelationManagers;
use App\Models\Region;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RegionResource extends Resource
{

    public static function canViewAny(): bool
    {
        return auth()->user()->can('Regions_view');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('Regions_create');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->can('Regions_edit');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->can('Regions_delete');
    }

    protected static ?string $model = Region::class;

    protected static ?string $navigationGroup = 'basic_notes'; // Group under "basic_notes"
    protected static ?string $navigationLabel = 'Regions'; // Sub-link label
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 5;

    public static function getModelLabel(): string
    {
        return trans('f28.region');
    }

    public static function getNavigationLabel(): string
    {
        return trans('f28.region');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('f28.region');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('p_code')
                    ->label('PCode')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('p_name')
                    ->label('PName')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('p_code')
                    ->label('PCode')
                    ->searchable(),
                Tables\Columns\TextColumn::make('p_name')
                    ->label('PName')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->modal(), // Edit action in modal
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
            'index' => BasicNotes\RegionResource\Pages\ListRegions::route('/'),
        ];
    }
}
