<div>
    <x-filament-widgets::widget>
        <x-slot name="header">
            <h2>Cheque Print Preview</h2>
        </x-slot>

        <div class="p-4 border border-gray-300 rounded-lg">
            <div class="flex justify-between">
                <div>
                    <p><strong>Bank:</strong> {{ $this->record->bankAccount->bank->name }}</p>
                    <p><strong>Branch:</strong> {{ $this->record->bankAccount->branch->branch_name }}</p>
                </div>
                <div>
                    <p><strong>Date:</strong> {{ now()->format('Y-m-d') }}</p>
                    <p><strong>Cheque Number:</strong> {{ $this->record->chequeIssue->cheque_number }}</p>
                </div>
            </div>
            <div class="mt-4">
                <p><strong>Pay to the order of:</strong> {{ $this->record->cheque_receiver }}</p>
            </div>
            <div class="mt-4">
                <p><strong>Amount:</strong> {{ number_format($this->record->total_amount, 2) }}</p>
            </div>
            <div class="mt-4">
                <p><strong>Amount in words:</strong> {{ (new NumberFormatter('en', NumberFormatter::SPELLOUT))->format($this->record->total_amount) }}</p>
            </div>
            <div class="mt-8 flex justify-between">
                <div>
                    <p><strong>Signature:</strong></p>
                    <div class="mt-2">
                        @foreach($this->record->chequeIssue->need_to_signature as $signature)
                            <div class="border-t border-gray-300 pt-2 mt-2">
                                {{ $signature }}
                            </div>
                        @endforeach
                    </div>
                </div>
                <div>
                    <p><strong>Cooperative Stamp:</strong></p>
                    <div class="mt-2">
                        @if($this->record->chequeIssue->cooperative_stamp)
                            <div class="w-24 h-24 border border-gray-300 flex items-center justify-center">
                                Stamp
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </x-filament-widgets::widget>
</div>
