<?php

namespace App\Filament\Resources\Payments\F5PaymentPerchByHeadOfficeResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PaymentDetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'paymentDetails';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('details')
                    ->label('Description')
                    ->required(),

                Forms\Components\TextInput::make('price')
                    ->label('Amount')
                    ->numeric()
                    ->required(),

                Forms\Components\Select::make('place_id')
                    ->label('Place/Branch')
                    ->options(function () {
                        $departmentId = $this->getOwnerRecord()->department_id;
                        return \App\Models\Branch::where('department_id', $departmentId)
                            ->pluck('name', 'id');
                    })
                    ->required()
                    ->searchable(),
            ])
            ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                $data['reference_table'] = $this->getOwnerRecord()->getReferenceTable();
                return $data;
            });
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('details')
                    ->label('Description'),

                Tables\Columns\TextColumn::make('price')
                    ->label('Amount')
                    ->numeric(decimalPlaces: 2),

                Tables\Columns\TextColumn::make('place.name')
                    ->label('Place/Branch'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
