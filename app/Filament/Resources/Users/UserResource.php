<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\UserResource\Pages;
use App\Filament\Resources\Users\UserResource\RelationManagers;
use App\Filament\Resources\Users;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    public static function canViewAny(): bool
    {
        if (auth()->user()->hasRole('Super Admin')){
            \Log::info('user manager Super admin ', [auth()->user()->can('UserManagement_view')]);
            return true;
        }
            \Log::info('user manager ', [auth()->user()->can('UserManagement_view')]);
        return auth()->user()->can('UserManagement_view');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('UserManagement_create');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->can('UserManagement_edit');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->can('UserManagement_delete');
    }

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'user';
    protected static ?int $navigationSort = 11;

    public static function getModelLabel(): string
    {
        return trans('f28.user_management');
    }

    public static function getNavigationLabel(): string
    {
        return trans('f28.user_management');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('f28.user_management');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255)
                    ->hiddenOn('edit'),
                Forms\Components\Select::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Users\UserResource\Pages\ListUsers::route('/'),
        ];
    }
}
