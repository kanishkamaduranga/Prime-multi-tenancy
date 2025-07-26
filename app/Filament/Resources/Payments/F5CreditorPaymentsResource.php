<?php

namespace App\Filament\Resources\Payments;

use App\Filament\Resources\Payments\F5CreditorPaymentsResource\Pages;
use App\Filament\Resources\Payments\F5CreditorPaymentsResource\RelationManagers;
use App\Models\F5CreditorPayment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Helpers\ImportantParameterHelper;

class F5CreditorPaymentsResource extends Resource
{
    protected static ?string $model = F5CreditorPayment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Payments';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('voucher_number')
                    ->label('Voucher Number')
                    ->disabled()
                    ->dehydrated(),
                Forms\Components\TextInput::make('coupon_number')
                    ->label('Coupon Number'),
                Forms\Components\Select::make('department_id')
                    ->label('Department')
                    ->options(fn () => \App\Models\Department::pluck('department', 'id'))
                    ->searchable()
                    ->required()
                    ->live(),
                Forms\Components\Select::make('supplier_id')
                    ->label('Supplier')
                    ->relationship('supplier', 'creditor_name')
                    ->options(fn () => \App\Models\Creditor::pluck('creditor_name', 'id'))
                    ->searchable()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        $supplier = \App\Models\Creditor::find($state);
                        if ($supplier) {
                            $set('cheque_receiver', $supplier->creditor_name);
                        }
                    }),
                Forms\Components\DatePicker::make('date_of_paid')
                    ->label('Date of Paid')
                    ->default(now())
                    ->required(),
                Forms\Components\Select::make('bank_account_id')
                    ->label('Bank Account')
                    ->options(function (Forms\Get $get) {
                        if (!$get('department_id')) {
                            return \App\Models\BankAccount::pluck('bank_account_name', 'id');
                        }
                        return \App\Models\BankAccount::where('department_id', $get('department_id'))
                            ->pluck('bank_account_name', 'id');
                    })
                    ->searchable()
                    ->required()
                    ->live(),
                Forms\Components\Placeholder::make('account_balance')
                    ->label('Account Balance')
                    ->content(function (Forms\Get $get) {
                        if (!$get('bank_account_id')) {
                            return 'N/A';
                        }

                        $account = \App\Models\BankAccount::find($get('bank_account_id'));
                        if (!$account) {
                            return 'N/A';
                        }

                        $balance = ImportantParameterHelper::getBankBalance($account->account_number);
                        return number_format($balance, 2);
                    }),
                Forms\Components\TextInput::make('cheque_receiver')
                    ->label('Cheque Receiver')
                    ->readOnly(),
                Forms\Components\Textarea::make('note')
                    ->label('Note'),
                Forms\Components\Repeater::make('paymentDetails')
                    ->relationship()
                    ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                        $data['reference_table'] = 'f5_creditor_payments';
                        return $data;
                    })
                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                        $total = 0;
                        foreach ($get('paymentDetails') as $detail) {
                            $total += $detail['price'];
                        }
                        $set('total_amount', $total);
                    })
                    ->schema([
                        Forms\Components\TextInput::make('details')
                            ->label('Details')
                            ->required(),
                        Forms\Components\TextInput::make('price')
                            ->label('Amount')
                            ->numeric()
                            ->required()
                            ->live(debounce: 500)
                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                                self::updateTotalAmount($get, $set);
                            }),
                        Forms\Components\Select::make('place_id')
                            ->label('Place')
                            ->options(function (Forms\Get $get) {
                                if (!$get('../../department_id')) {
                                    return \App\Models\Branch::pluck('branch_name', 'id');
                                }
                                return \App\Models\Branch::where('department_id', $get('../../department_id'))
                                    ->pluck('branch_name', 'id');
                            })
                            ->searchable()
                            ->required(),
                    ])
                    ->columns(3)
                    ->defaultItems(1)
                    ->addActionLabel('Add Payment Detail')
                    ->reorderable()
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => $state['details'] ?? null),
                Forms\Components\Placeholder::make('total_amount_placeholder')
                    ->label('Total Amount')
                    ->content(function (Forms\Get $get) {
                        $total = 0;
                        foreach ($get('paymentDetails') ?? [] as $detail) {
                            $total += $detail['price'] ?? 0;
                        }
                        return number_format($total, 2);
                    }),
                Forms\Components\Hidden::make('total_amount')
                    ->default(0),
                Forms\Components\Select::make('payment_type')
                    ->label('Payment Type')
                    ->options(ImportantParameterHelper::getValues('payment_types'))
                    ->required(),

            ]);
    }

    private static function updateTotalAmount(Forms\Get $get, Forms\Set $set): void
    {
        $total = 0;
        foreach ($get('paymentDetails') ?? [] as $detail) {
            $total += $detail['amount'] ?? 0;
        }
        $set('total_amount', $total);
        $set('total_amount_placeholder', number_format($total, 2));
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('voucher_number'),
                Tables\Columns\TextColumn::make('department.department'),
                Tables\Columns\TextColumn::make('supplier.creditor_name'),
                Tables\Columns\TextColumn::make('total_amount'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->url(fn ($record) => self::getUrl('edit', ['record' => $record])),
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
            RelationManagers\PaymentDetailsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListF5CreditorPayments::route('/'),
            'create' => Pages\CreateF5CreditorPayment::route('/create'),
            'edit' => Pages\EditF5CreditorPayment::route('/{record}/edit'),
        ];
    }
}
