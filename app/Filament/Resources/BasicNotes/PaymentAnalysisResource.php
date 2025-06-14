<?php

namespace App\Filament\Resources\BasicNotes;

use App\Filament\Resources\BasicNotes;
use App\Filament\Resources\BasicNotes\PaymentAnalysisResource\Pages;
use App\Filament\Resources\BasicNotes\PaymentAnalysisResource\RelationManagers;
use App\Models\PaymentAnalysis;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PaymentAnalysisResource extends Resource
{
    protected static ?string $model = PaymentAnalysis::class;

    protected static ?string $navigationGroup = 'basic_notes';

    protected static ?string $navigationIcon = 'heroicon-o-bars-arrow-down';

    protected static ?int $navigationSort = 14;

    public static function getModelLabel(): string
    {
        return trans('f28.payment_analysis');
    }

    public static function getNavigationLabel(): string
    {
        return trans('f28.payment_analysis');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('f28.payment_analysis');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('analysis_number')
                    ->label(__('f28.analysis_number'))
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('payment_analysis')
                    ->label(__('f28.payment_analysis'))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('analysis_number')->label(__('f28.analysis_number'))->sortable()->searchable(),
                TextColumn::make('payment_analysis')->label(__('f28.payment_analysis'))->sortable()->searchable(),
                TextColumn::make('created_at')->label('Created At')->dateTime(),
                TextColumn::make('updated_at')->label('Updated At')->dateTime(),
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
            'index' => BasicNotes\PaymentAnalysisResource\Pages\ListPaymentAnalyses::route('/'),
        ];
    }
}
