<?php

namespace App\Filament\Resources\Payments;

use App\Filament\Resources\Payments\F5PaymentPerchByHeadOfficeResource\Pages;
use App\Filament\Resources\Payments\F5PaymentPerchByHeadOfficeResource\RelationManagers;
use App\Filament\Resources\Payments;
use App\Helpers\ImportantParameterHelper;
use App\Models\F5PaymentPerchByHeadOffice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Helpers\ValidationHelper;

class F5PaymentPerchByHeadOfficeResource extends Resource
{
    protected static ?string $model = F5PaymentPerchByHeadOffice::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'payments';

    public static function getModelLabel(): string
    {
        return trans('f28.f5_payment_perch_by_head_office');
    }

    public static function getNavigationLabel(): string
    {
        return trans('f28.f5_payment_perch_by_head_office');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('f28.f5_payment_perch_by_head_office');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('f28.regular_payments'))
                    ->schema([

                        Forms\Components\TextInput::make('voucher_number')
                            ->label(__('f28.voucher_number'))
                            ->disabled()
                            ->dehydrated(),

                        Forms\Components\TextInput::make('cooppen_number')
                            ->label(__('f28.cooppen_number'))
                            ->nullable(),

                        Forms\Components\Select::make('department_id')
                            ->label(__('f28.department'))
                            ->options(fn () => \App\Models\Department::pluck('department', 'id'))
                            ->required()
                            ->loadingMessage('Loading valid departments...')
                            ->helperText('Some departments may be disabled based on validation rules')
                            ->disableOptionWhen(function (string $value) {
                                $validDepartments = app(ValidationHelper::class)
                                    ->formConfigValidation('F5PaymentPerchByHeadOfficeResource');
                                return !in_array($value, $validDepartments);
                            })
                            ->live()
                            ->searchable(),

                        Forms\Components\Select::make('supplier_id')
                            ->label(__('f28.supplier'))
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
                            ->label(__('f28.bank_account'))
                            ->options(function (Forms\Get $get) {
                                if (!$get('department_id')) {
                                    return \App\Models\BankAccount::pluck('bank_account_name', 'id');
                                }
                                return \App\Models\BankAccount::where('department_id', $get('department_id'))
                                    ->pluck('bank_account_name', 'id');
                            })
                            ->required()
                            ->searchable()
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set)  {
                                $account = \App\Models\BankAccount::find($state);
                                if ($account) {
                                    $balance = ImportantParameterHelper::getBankBalance($account->account_number);
                                    $set('existing_account_balance', $balance);
                                }
                            }),

                        Forms\Components\Placeholder::make('account_balance')
                            ->label(__('f28.account_balance'))
                            ->content(function (Forms\Get $get) {
                                if (!$get('bank_account_id')) {
                                    return 'N/A';
                                }

                                $account = \App\Models\BankAccount::find($get('bank_account_id'));
                                if (!$account) {
                                    return 'N/A';
                                }

                                $balance = ImportantParameterHelper::getBankBalance($account->account_number);
                                return number_format($balance, 2) . ' ' . $account->currency;
                            })
                            ->extraAttributes([
                                'class' => 'self-end pb-1', // Aligns with select input
                            ])
                            ->columnSpan(1),


                        Forms\Components\TextInput::make('cheque_receiver')
                            ->label('Cheque Receiver')
                            ->required(),

                        Forms\Components\Textarea::make('summary')
                            ->label(__('f28.summary'))
                            ->nullable()
                            ->columnSpanFull(),

                        Forms\Components\Select::make('payment_type')
                            ->label(__('f28.payment_type'))
                            ->options(ImportantParameterHelper::getValues('payment_types'))
                            ->required(),

                        Forms\Components\Hidden::make('payment_analysis')
                            ->default('payment'),

                        Forms\Components\Hidden::make('total_amount')
                            ->default(0)
                            ->dehydrated()
                            ->afterStateHydrated(function (Forms\Set $set, Forms\Get $get) {
                                // Calculate initial total when editing
                                $total = 0;
                                foreach ($get('paymentDetails') ?? [] as $detail) {
                                    $total += $detail['price'] ?? 0;
                                }
                                $set('total_amount', $total);
                            }),

                        Forms\Components\Hidden::make('existing_account_balance')->default(0)->dehydrated(),
                        Forms\Components\Hidden::make('status')->default('pending')->dehydrated(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make(__('f28.payment_details'))
                    ->schema([
                        Forms\Components\Repeater::make('paymentDetails')
                            ->relationship()
                            ->mutateRelationshipDataBeforeCreateUsing(function (array $data, $record): array {
                                $data['reference_table'] = $record->getReferenceTable();
                                return $data;
                            })
                            ->schema([
                                Forms\Components\TextInput::make('details')
                                    ->label(__('f28.description'))
                                    ->required(),

                                Forms\Components\TextInput::make('price')
                                    ->label(__('f28.amount'))
                                    ->numeric()
                                    ->required()
                                    ->live(debounce: 500) // Add live update
                                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                                        self::updateTotalAmount($get, $set);
                                    }),

                                Forms\Components\Select::make('place_id')
                                    ->label(__('f28.place_branch'))
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
                            ->addActionLabel(__('f28.add_payment_detail'))
                            ->reorderable()
                            ->collapsible()
                            ->live()
                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                                $total = 0;
                                foreach ($get('paymentDetails') ?? [] as $detail) {
                                    $total += $detail['price'] ?? 0;
                                }
                                $set('total_amount', $total);
                            })
                            ->itemLabel(fn (array $state): ?string => $state['details'] ?? null),

                        Forms\Components\Placeholder::make('total_amount_display')
                            ->label(__('f28.total_amount'))
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

    public static function fillForm(Form $form): Form
    {
        \Log::info('Fill form called'); // Debugging

        return $form
            ->schema(static::form($form)->getComponents())
            ->state([
                'status' => 'pending',
                'total_amount' => 0,
                'existing_account_balance' => 0,
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

                Tables\Columns\TextColumn::make('status')
                    ->label(__('f28.status'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'completed' => 'primary',
                    }),

                Tables\Columns\TextColumn::make('voucher_number')
                    ->label(__('f28.voucher_number'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('department.department')
                    ->label(__('f28.department'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('supplier.creditor_name')
                    ->label(__('f28.supplier'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('payment_type')
                    ->label(__('f28.payment_type')),

                Tables\Columns\TextColumn::make('total_amount')
                    ->label(__('f28.total_amount'))
                    ->numeric(decimalPlaces: 2)
                    ->state(function ($record) {
                        return $record->paymentDetails->sum('price');
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('f28.date'))
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
            Payments\F5PaymentPerchByHeadOfficeResource\RelationManagers\PaymentDetailsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Payments\F5PaymentPerchByHeadOfficeResource\Pages\ListF5PaymentPerchByHeadOffices::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['department', 'supplier', 'paymentDetails'])
            ->where('created_by', auth()->id());
    }
}
