<?php

namespace App\Filament\Resources\BasicNotes;

use App\Filament\Resources\BasicNotes;
use App\Filament\Resources\BasicNotes\ExternalPersonResource\Pages;
use App\Filament\Resources\BasicNotes\ExternalPersonResource\RelationManagers;
use App\Models\ExternalPerson;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ExternalPersonResource extends Resource
{
    protected static ?string $model = ExternalPerson::class;

    protected static ?string $navigationIcon = 'heroicon-o-hand-raised';
    protected static ?string $navigationGroup = 'basic_notes';

    protected static ?int $navigationSort = 21;

    public static function getModelLabel(): string
    {
        return trans('f28.external_person');
    }

    public static function getNavigationLabel(): string
    {
        return trans('f28.external_person');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('f28.external_person');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('number')
                    ->required()
                    ->maxLength(50)
                    ->unique(ignoreRecord: true)
                    ->label(__('f28.external_person_number')),

                Forms\Components\TextInput::make('customer_number')
                    ->maxLength(30)
                    ->label(__('f28.customer_number'))
                    ->nullable(),

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label(__('f28.name')),

                Forms\Components\Textarea::make('address')
                    ->maxLength(500)
                    ->label(__('f28.address'))
                    ->nullable(),

                Forms\Components\TextInput::make('nic_number')
                    ->required()
                    ->maxLength(12)
                    ->label(__('f28.nic_number'))
                    ->rules([
                        'regex:/^\d{12}$|^\d{9}[VvXx]$/i', // Validate 12 digits or 9 digits + 'V' or 'X'
                    ])
                    ->validationMessages([
                        'regex' => __('f28.nic_validate'),
                    ]),

                Forms\Components\TextInput::make('telephone_number')
                    ->required()
                    ->maxLength(10)
                    ->label(__('f28.telephone_number'))
                    ->rules([
                        'regex:/^0\d{9}$/', // Validate 10 digits starting with 0
                    ])
                    ->validationMessages([
                        'regex' => __('f28.telephone_number_validate'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number')
                    ->label(__('f28.external_person_number'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('customer_number')
                    ->label(__('f28.customer_number'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('f28.name'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('nic_number')
                    ->label(__('f28.nic_number'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('telephone_number')
                    ->label(__('f28.telephone_number'))
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
            'index' => BasicNotes\ExternalPersonResource\Pages\ListExternalPeople::route('/'),
        ];
    }
}
