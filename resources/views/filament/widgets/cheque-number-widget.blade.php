<div>
    <x-filament-widgets::widget>
        <x-slot name="header">
            <h2>Cheque Number Details</h2>
        </x-slot>

        <div class="p-4">
            <p><strong>Cheque Number:</strong> {{ $this->record->chequeIssue->cheque_number }}</p>
            <p><strong>Note:</strong> {{ $this->record->chequeIssue->note_cheque_number_issue }}</p>
            <p><strong>By:</strong> {{ $this->record->chequeIssue->chequeNumberIssueBy->name }}</p>
            <p><strong>Date:</strong> {{ $this->record->chequeIssue->check_number_issued_time }}</p>
        </div>
    </x-filament-widgets::widget>
</div>
