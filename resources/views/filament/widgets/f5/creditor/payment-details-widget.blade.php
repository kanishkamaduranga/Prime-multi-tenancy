<div>
    <x-filament-widgets::widget>
        <x-slot name="header">
            <h2>Payment Details</h2>
        </x-slot>

        <div class="p-4">
            <p><strong>Voucher Number:</strong> {{ $this->record->voucher_number }}</p>
            <p><strong>Coupon Number:</strong> {{ $this->record->coupon_number }}</p>
            <p><strong>Department:</strong> {{ $this->record->department->department }}</p>
            <p><strong>Supplier:</strong> {{ $this->record->supplier->creditor_name }}</p>
            <p><strong>Date of Paid:</strong> {{ $this->record->date_of_paid }}</p>
            <p><strong>Bank Account:</strong> {{ $this->record->bankAccount->bank_account_name }}</p>
            <p><strong>Cheque Receiver:</strong> {{ $this->record->cheque_receiver }}</p>
            <p><strong>Note:</strong> {{ $this->record->note }}</p>
            <p><strong>Total Amount:</strong> {{ $this->record->total_amount }}</p>
            <p><strong>Payment Type:</strong> {{ $this->record->payment_type }}</p>

            <h3 class="text-lg font-semibold mt-4">Payment Details</h3>
            <table class="w-full mt-2">
                <thead>
                    <tr>
                        <th class="text-left">Details</th>
                        <th class="text-left">Amount</th>
                        <th class="text-left">Place</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($this->record->paymentDetails as $detail)
                        <tr>
                            <td>{{ $detail->details }}</td>
                            <td>{{ $detail->price }}</td>
                            <td>{{ $detail->place->branch_name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p><strong>Payment Created By:</strong> {{ $this->record->paymentCreatedBy->name }}</p>
            <p><strong>Created At:</strong> {{ $this->record->created_at }}</p>
        </div>
    </x-filament-widgets::widget>
</div>
