@props(['record'])

<div class="space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('f28.voucher_number') }}</label>
            <div class="mt-1 text-sm text-gray-900 dark:text-white">{{ $record->voucher_number }}</div>
        </div>

        <div>
            <label class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('f28.cooppen_number') }}</label>
            <div class="mt-1 text-sm text-gray-900 dark:text-white">{{ $record->cooppen_number }}</div>
        </div>

        <div>
            <label class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('f28.department') }}</label>
            <div class="mt-1 text-sm text-gray-900 dark:text-white">{{ $record->department->department }}</div>
        </div>

        <div>
            <label class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('f28.supplier') }}</label>
            <div class="mt-1 text-sm text-gray-900 dark:text-white">{{ $record->supplier->creditor_name }}</div>
        </div>

        <div>
            <label class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('f28.bank_account') }}</label>
            <div class="mt-1 text-sm text-gray-900 dark:text-white">{{ $record->bankAccount->bank_account_name }}</div>
        </div>

        <div>
            <label class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('f28.account_balance') }}</label>
            <div class="mt-1 text-sm text-gray-900 dark:text-white">{{ number_format($record->existing_account_balance, 2) }}</div>
        </div>

        <div>
            <label class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('f28.cheque_receiver') }}</label>
            <div class="mt-1 text-sm text-gray-900 dark:text-white">{{ $record->cheque_receiver }}</div>
        </div>

        <div>
            <label class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('f28.payment_type') }}</label>
            <div class="mt-1 text-sm text-gray-900 dark:text-white">{{ $record->payment_type }}</div>
        </div>
    </div>

    <div>
        <label class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('f28.summary') }}</label>
        <div class="mt-1 text-sm text-gray-900 dark:text-white">{{ $record->summary }}</div>
    </div>

    <x-filament-tables::container>
        <x-filament-tables::table>
            <x-slot name="header">
                <x-filament-tables::header-cell>{{ __('f28.description') }}</x-filament-tables::header-cell>
                <x-filament-tables::header-cell>{{ __('f28.amount') }}</x-filament-tables::header-cell>
                <x-filament-tables::header-cell>{{ __('f28.place_branch') }}</x-filament-tables::header-cell>
            </x-slot>

            @foreach($record->paymentDetails as $detail)
                <x-filament-tables::row>
                    <x-filament-tables::cell>{{ $detail->details }}</x--filament-tables::cell>
                    <x-filament-tables::cell>{{ number_format($detail->price, 2) }}</x-filament-tables::cell>
                    <x-filament-tables::cell>{{ $detail->place->branch_name }}</x-filament-tables::cell>
                </x-filament-tables::row>
            @endforeach

            <x-slot name="footer">
                <x-filament-tables::row>
                    <x-filament-tables::cell colspan="1" class="text-right font-bold">{{ __('f28.total_amount') }}</x-filament-tables::cell>
                    <x-filament-tables::cell class="font-bold">{{ number_format($record->paymentDetails->sum('price'), 2) }}</x-filament-tables::cell>
                    <x-filament-tables::cell></x-filament-tables::cell>
                </x-filament-tables::row>
            </x-slot>
        </x-filament-tables::table>
    </x-filament-tables::container>
</div>
