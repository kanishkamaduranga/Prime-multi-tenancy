@props(['record'])

<div class="space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <x-filament::input-wrapper>
            <x-slot name="label">{{ __('f28.voucher_number') }}</x-slot>
            <x-filament::input.text value="{{ $record->voucher_number }}" disabled />
        </x-filament::input-wrapper>

        <x-filament::input-wrapper>
            <x-slot name="label">{{ __('f28.cooppen_number') }}</x-slot>
            <x-filament::input.text value="{{ $record->cooppen_number }}" disabled />
        </x-filament::input-wrapper>

        <x-filament::input-wrapper>
            <x-slot name="label">{{ __('f28.department') }}</x-slot>
            <x-filament::input.text value="{{ $record->department->department }}" disabled />
        </x-filament::input-wrapper>

        <x-filament::input-wrapper>
            <x-slot name="label">{{ __('f28.supplier') }}</x-slot>
            <x-filament::input.text value="{{ $record->supplier->creditor_name }}" disabled />
        </x-filament::input-wrapper>

        <x-filament::input-wrapper>
            <x-slot name="label">{{ __('f28.bank_account') }}</x-slot>
            <x-filament::input.text value="{{ $record->bankAccount->bank_account_name }}" disabled />
        </x-filament::input-wrapper>

        <x-filament::input-wrapper>
            <x-slot name="label">{{ __('f28.account_balance') }}</x-slot>
            <x-filament::input.text value="{{ number_format($record->existing_account_balance, 2) }}" disabled />
        </x-filament::input-wrapper>

        <x-filament::input-wrapper>
            <x-slot name="label">{{ __('f28.cheque_receiver') }}</x-slot>
            <x-filament::input.text value="{{ $record->cheque_receiver }}" disabled />
        </x-filament::input-wrapper>

        <x-filament::input-wrapper>
            <x-slot name="label">{{ __('f28.payment_type') }}</x-slot>
            <x-filament::input.text value="{{ $record->payment_type }}" disabled />
        </x-filament::input-wrapper>
    </div>

    <x-filament::input-wrapper>
        <x-slot name="label">{{ __('f28.summary') }}</x-slot>
        <x-filament::input.textarea value="{{ $record->summary }}" disabled />
    </x-filament::input-wrapper>

    <x-filament-tables::container>
        <x-filament-tables::table>
            <x-slot name="header">
                <x-filament-tables::header-cell>{{ __('f28.description') }}</x-filament-tables::header-cell>
                <x-filament-tables::header-cell>{{ __('f28.amount') }}</x-filament-tables::header-cell>
                <x-filament-tables::header-cell>{{ __('f28.place_branch') }}</x-filament-tables::header-cell>
            </x-slot>

            @foreach($record->paymentDetails as $detail)
                <x-filament-tables::row>
                    <x-filament-tables::cell>{{ $detail->details }}</x-filament-tables::cell>
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
