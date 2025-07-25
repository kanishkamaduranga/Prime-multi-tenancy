<?php

namespace App\Filament\Resources\Payments\F5CreditorPaymentsResource\Pages;

use App\Filament\Resources\Payments\F5CreditorPaymentsResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms;
use App\Models\F5CreditorPayment;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;

class EditF5CreditorPayment extends EditRecord
{
    protected static string $resource = F5CreditorPaymentsResource::class;

    public $state = [];

    protected function getHeaderWidgets(): array
    {
        $status = $this->record->status;
        $widgets = [];

        $widgets[] = \App\Filament\Widgets\PaymentDetailsWidget::class;

        if (in_array($status, ['approved', 'rejected', 'cheque_number_issued', 'cheque_issued', 'cheque_printed'])) {
            $widgets[] = \App\Filament\Widgets\ApprovalWidget::class;
        }

        if (in_array($status, ['cheque_number_issued', 'cheque_issued', 'cheque_printed'])) {
            $widgets[] = \App\Filament\Widgets\ChequeNumberWidget::class;
        }

        if (in_array($status, ['cheque_issued', 'cheque_printed'])) {
            $widgets[] = \App\Filament\Widgets\ChequeIssuedWidget::class;
        }

        return $widgets;
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getFormSchema(): array
    {
        $status = $this->record->status;

        return [
            Forms\Components\Wizard::make([
                Forms\Components\Wizard\Step::make('Payment Form')
                    ->schema([
                        Forms\Components\Section::make()->schema(
                            F5CreditorPaymentsResource::getFormSchema()
                        )->columns(2)
                    ])
                    ->visible(auth()->user()->can('f5_creaditor-payments_create')),

                Forms\Components\Wizard\Step::make('Approval')
                    ->schema([
                        Forms\Components\Textarea::make('note_approved_or_rejected')
                            ->label('Note'),
                    ])
                    ->visible(auth()->user()->can('f5_creaditor-payments_approve') && $status === 'pending'),

                Forms\Components\Wizard\Step::make('Issue Cheque Number')
                    ->schema([
                        Forms\Components\TextInput::make('cheque_number')
                            ->label('Cheque Number')
                            ->required(),
                        Forms\Components\Textarea::make('note_cheque_number_issue')
                            ->label('Note'),
                    ])
                    ->visible(auth()->user()->can('f5_creaditor-payments_cheque_number_issue') && $status === 'approved'),

                Forms\Components\Wizard\Step::make('Issue Cheque')
                    ->schema([
                        Forms\Components\Checkbox::make('cooperative_stamp')
                            ->label('Cooperative Stamp'),
                        Forms\Components\Radio::make('valid_date')
                            ->label('Valid Date')
                            ->options(ImportantParameterHelper::getValues('cheques_valid_dates'))
                            ->required(),
                        Forms\Components\Radio::make('permissions')
                            ->label('Permissions')
                            ->options(ImportantParameterHelper::getValues('cheques_permissions'))
                            ->required(),
                        Forms\Components\CheckboxList::make('need_to_signature')
                            ->label('Need to Signature')
                            ->options(ImportantParameterHelper::getValues('cheques_signatures'))
                            ->required(),
                    ])
                    ->visible(auth()->user()->can('f5_creaditor-payments_cheque_issue') && $status === 'cheque_number_issued'),

                Forms\Components\Wizard\Step::make('Print Cheque')
                    ->schema([
                        \App\Filament\Widgets\ChequePrintPreview::class,
                    ])
                    ->visible(auth()->user()->can('f5_creaditor-payments_cheque_print') && $status === 'cheque_issued'),
            ])->startOnStep($this->getStartStep()),
        ];
    }

    protected function getStartStep(): int
    {
        return match ($this->record->status) {
            'pending' => 1,
            'approved' => 2,
            'cheque_number_issued' => 3,
            'cheque_issued' => 4,
            'cheque_printed' => 5,
            default => 1,
        };
    }

    protected function getFormActions(): array
    {
        $status = $this->record->status;
        $actions = [];

        if ($status === 'pending' && auth()->user()->can('f5_creaditor-payments_approve')) {
            $actions[] = Action::make('approve')
                ->label('Approve')
                ->action('approve');
            $actions[] = Action::make('reject')
                ->label('Reject')
                ->action('reject');
        }

        if ($status === 'approved' && auth()->user()->can('f5_creaditor-payments_cheque_number_issue')) {
            $actions[] = Action::make('issue_cheque_number')
                ->label('Issue Cheque Number')
                ->action('issueChequeNumber');
        }

        if ($status === 'cheque_number_issued' && auth()->user()->can('f5_creaditor-payments_cheque_issue')) {
            $actions[] = Action::make('issue_cheque')
                ->label('Issue Cheque')
                ->action('issueCheque');
        }

        if ($status === 'cheque_issued' && auth()->user()->can('f5_creaditor-payments_cheque_print')) {
            $actions[] = Action::make('print_cheque')
                ->label('Print Cheque')
                ->action('printCheque');
        }

        return $actions;
    }

    public function approve(): void
    {
        $this->record->update([
            'status' => 'approved',
            'approved_or_rejected_by' => auth()->id(),
            'approved_or_rejected_time' => now(),
        ]);
    }

    public function reject(): void
    {
        $this->record->update([
            'status' => 'rejected',
            'approved_or_rejected_by' => auth()->id(),
            'approved_or_rejected_time' => now(),
        ]);
    }

    protected function fillForm(): void
    {
        parent::fillForm();
        $this->state = $this->form->getState();
    }

    public function issueChequeNumber(): void
    {
        $this->record->chequeIssue()->create([
            'cheque_number' => $this->state['cheque_number'],
            'note_cheque_number_issue' => $this->state['note_cheque_number_issue'],
            'cheque_number_issue_by' => auth()->id(),
            'check_number_issued_time' => now(),
        ]);
        $this->record->update(['status' => 'cheque_number_issued']);
    }

    public function issueCheque(): void
    {
        $data = $this->form->getState();
        $this->record->chequeIssue->update([
            'cooperative_stamp' => $data['cooperative_stamp'],
            'valid_date' => $data['valid_date'],
            'permissions' => $data['permissions'],
            'need_to_signature' => $data['need_to_signature'],
            'cheque_issue_by' => auth()->id(),
            'cheque_issue_time' => now(),
        ]);
        $this->record->update(['status' => 'cheque_issued']);
    }

    public function printCheque(): void
    {
        $this->record->chequeIssue->increment('cheque_printed_time');
        $this->record->update(['status' => 'cheque_printed']);
    }
}
