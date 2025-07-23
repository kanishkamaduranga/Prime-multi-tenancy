<div>
    <x-filament-widgets::widget>
        <x-slot name="header">
            <h2>Approval Details</h2>
        </x-slot>

        <div class="p-4">
            <p><strong>Status:</strong> {{ $this->record->status }}</p>
            <p><strong>Note:</strong> {{ $this->record->note_approved_or_rejected }}</p>
            <p><strong>By:</strong> {{ $this->record->approvedOrRejectedBy->name ?? '' }}</p>
            <p><strong>Date:</strong> {{ $this->record->approved_or_rejected_time }}</p>
        </div>
    </x-filament-widgets::widget>
</div>
