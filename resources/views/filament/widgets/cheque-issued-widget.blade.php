<div>
    <x-filament-widgets::widget>
        <x-slot name="header">
            <h2>Cheque Issued Details</h2>
        </x-slot>

        <div class="p-4">
            <p><strong>Cooperative Stamp:</strong> {{ $this->record->chequeIssue->cooperative_stamp ? 'Yes' : 'No' }}</p>
            <p><strong>Valid Date:</strong> {{ $this->record->chequeIssue->valid_date }}</p>
            <p><strong>Permissions:</strong> {{ $this->record->chequeIssue->permissions }}</p>
            <p><strong>Need to Signature:</strong> {{ implode(', ', $this->record->chequeIssue->need_to_signature) }}</p>
            <p><strong>By:</strong> {{ $this->record->chequeIssue->chequeIssueBy->name }}</p>
            <p><strong>Date:</strong> {{ $this->record->chequeIssue->cheque_issue_time }}</p>
        </div>
    </x-filament-widgets::widget>
</div>
