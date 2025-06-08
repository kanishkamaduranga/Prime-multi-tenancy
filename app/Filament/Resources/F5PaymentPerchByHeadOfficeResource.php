<?php

namespace App\Filament\Resources;

use App\Filament\Resources\F5PaymentPerchByHeadOfficeResource\Pages;
use App\Filament\Resources\F5PaymentPerchByHeadOfficeResource\RelationManagers;
use App\Models\F5PaymentPerchByHeadOffice;
use App\Helpers\ImportantParameterHelper;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class F5PaymentPerchByHeadOfficeResource extends Resource
{
    protected static ?string $model = F5PaymentPerchByHeadOffice::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Payments';

    protected static ?string $modelLabel = 'Payment Perched by Head Office';

    protected static ?string $pluralModelLabel = 'Payments Perched by Head Office';

    protected static ?string $navigationLabel = 'Payments Perched by HO';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Payment Information')
                    ->schema([
                        Forms\Components\TextInput::make('voucher_number')
                            ->label('Voucher Number')
                            ->disabled()
                            ->dehydrated(),

                        Forms\Components\TextInput::make('cooppen_number')
                            ->label('Cooppen Number')
                            ->nullable(),

                        Forms\Components\Select::make('department_id')
                            ->label('Department')
                            ->options(fn () => \App\Models\Department::pluck('department', 'id'))
                            ->required()
                            ->live()
                            ->searchable(),

                        Forms\Components\Select::make('supplier_id')
                            ->label('Supplier')
                            ->options(fn () => \App\Models\Creditor::pluck('creditor_name', 'id'))
                            ->required()
                            ->live()
                            ->searchable()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                $supplier = \App\Models\Creditor::find($state);
                                if ($supplier) {
                                    $set('cheque_receiver', $supplier->creditor_name);
                                }
                            }),

                        Forms\Components\Select::make('bank_account_id')
                            ->label('Bank Account')
                            ->options(function (Forms\Get $get) {
                                if (!$get('department_id')) {
                                    return \App\Models\BankAccount::pluck('bank_account_name', 'id');
                                }
                                return \App\Models\BankAccount::where('department_id', $get('department_id'))
                                    ->pluck('bank_account_name', 'id');
                            })
                            ->required()
                            ->searchable(),

                        Forms\Components\TextInput::make('cheque_receiver')
                            ->label('Cheque Receiver')
                            ->required(),

                        Forms\Components\Textarea::make('summary')
                            ->label('Summary')
                            ->nullable()
                            ->columnSpanFull(),

                        Forms\Components\Select::make('payment_type')
                            ->label('Payment Type')
                            ->options(ImportantParameterHelper::getValues('payment_types'))
                            ->required(),

                        Forms\Components\Hidden::make('payment_analysis')
                            ->default('payment'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Payment Details')
                    ->schema([
                        Forms\Components\Repeater::make('paymentDetails')
                            ->relationship()
                            ->mutateRelationshipDataBeforeCreateUsing(function (array $data, $record): array {
                                $data['reference_table'] = $record->getReferenceTable();
                                return $data;
                            })
                            ->schema([
                                Forms\Components\TextInput::make('details')
                                    ->label('Description')
                                    ->required(),

                                Forms\Components\TextInput::make('price')
                                    ->label('Amount')
                                    ->numeric()
                                    ->required()
                                    ->live(debounce: 500) // Add live update
                                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                                        self::updateTotalAmount($get, $set);
                                    }),

                                Forms\Components\Select::make('place_id')
                                    ->label('Place/Branch')
                                    ->options(function (Forms\Get $get) {
                                        if (!$get('../../department_id')) {
                                            return \App\Models\Branch::pluck('branch_name', 'id');
                                        }
                                        return \App\Models\Branch::where('department_id', $get('../../department_id'))
                                            ->pluck('branch_name', 'id');
                                    })
                                    ->required()
                                    ->searchable(),
                            ])
                            ->columns(3)
                            ->defaultItems(1)
                            ->addActionLabel('Add Payment Detail')
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['details'] ?? null),

                        Forms\Components\Placeholder::make('total_amount')
                            ->label('Total Amount')
                            ->content(function (Forms\Get $get) {
                                $total = 0;
                                foreach ($get('paymentDetails') ?? [] as $detail) {
                                    $total += $detail['price'] ?? 0;
                                }
                                return number_format($total, 2);
                            })
                            ->live(),
                    ]),
            ]);
    }

    private static function updateTotalAmount(Forms\Get $get, Forms\Set $set): void
    {
        $total = 0;
        foreach ($get('paymentDetails') ?? [] as $detail) {
            $total += $detail['price'] ?? 0;
        }
        $set('total_amount', number_format($total, 2));
    }

    protected static function getRepeaterLiveTriggers(): array
    {
        return [
            'paymentDetails.*.price' => 'paymentDetailsUpdated',
        ];
    }

    protected static function getRepeaterLiveListeners(): array
    {
        return [
            'paymentDetailsUpdated' => 'updateTotalAmount',
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('voucher_number')
                    ->label('Voucher No')
                    ->searchable(),

                Tables\Columns\TextColumn::make('department.department')
                    ->label('Department')
                    ->searchable(),

                Tables\Columns\TextColumn::make('supplier.creditor_name')
                    ->label('Supplier')
                    ->searchable(),

                Tables\Columns\TextColumn::make('payment_type')
                    ->label('Payment Type'),

                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total Amount')
                    ->numeric(decimalPlaces: 2)
                    ->state(function ($record) {
                        return $record->paymentDetails->sum('price');
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->date(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('department_id')
                    ->label('Department')
                    ->options(fn () => \App\Models\Department::pluck('department', 'id'))
                    ->searchable(),

                Tables\Filters\SelectFilter::make('payment_type')
                    ->options(ImportantParameterHelper::getValues('payment_types')),
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
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PaymentDetailsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListF5PaymentPerchByHeadOffices::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['department', 'supplier', 'paymentDetails'])
            ->where('created_by', auth()->id());
    }
}
