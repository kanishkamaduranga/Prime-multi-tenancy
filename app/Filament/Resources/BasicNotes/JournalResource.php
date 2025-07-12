<?php

namespace App\Filament\Resources\BasicNotes;

use App\Filament\Resources\BasicNotes;
use App\Filament\Resources\BasicNotes\JournalResource\Pages;
use App\Filament\Resources\BasicNotes\JournalResource\RelationManagers;
use App\Models\Journal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JournalResource extends Resource
{
    public static function canViewAny(): bool
    {
        return auth()->user()->can('Journals_view');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('Journals_create');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->can('Journals_edit');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->can('Journals_delete');
    }

    protected static ?string $model = Journal::class;
    protected static ?string $navigationGroup = 'basic_notes';
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?int $navigationSort = 13;

    public static function getModelLabel(): string
    {
        return trans('f28.journal');
    }

    public static function getNavigationLabel(): string
    {
        return trans('f28.journal');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('f28.journal');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('department_id')
                    ->relationship('department', 'department') // Assuming 'name' is a field in the departments table
                    ->required()
                    ->label(__('f28.department')),

                Forms\Components\TextInput::make('journal_number')
                    ->required()
                    ->maxLength(30)
                    ->label(__('f28.journal_number')),

                Forms\Components\TextInput::make('journal')
                    ->required()
                    ->maxLength(255)
                    ->label(__('f28.journal')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('department.department')
                    ->label(__('f28.department'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('journal_number')
                    ->label(__('f28.journal_number'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('journal')
                    ->label(__('f28.journal'))
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
            'index' => BasicNotes\JournalResource\Pages\ListJournals::route('/'),
        ];
    }
}
