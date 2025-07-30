<?php

namespace App\Filament\Resources\Payments\F5PaymentPerchByHeadOfficeResource\Pages;

use App\Filament\Resources\Payments\F5PaymentPerchByHeadOfficeResource;
use App\Models\F5PaymentPerchByHeadOffice;
use Filament\Resources\Pages\Page;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ApprovePayment extends Page
{
    protected static string $resource = F5PaymentPerchByHeadOfficeResource::class;

    protected static string $view = 'filament.resources.payments.f5-payment-perch-by-head-office-resource.pages.approve-payment';

    public F5PaymentPerchByHeadOffice $record;

    public function mount(int | string $record): void
    {
        $this->record = F5PaymentPerchByHeadOffice::findOrFail($record);
    }

    public function getTitle(): string
    {
        return __('f28.approval');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('approve')
                ->label(__('f28.approve'))
                ->color('success')
                ->action('approve'),

            Action::make('reject')
                ->label(__('f28.reject'))
                ->color('danger')
                ->action('reject'),
        ];
    }

    public function approve(): void
    {
        $this->record->update([
            'status' => 'approved',
            'approved_or_rej_by' => Auth::id(),
            'approved_or_rej_at' => Carbon::now(),
        ]);

        Notification::make()
            ->title(__('f28.approved_successfully'))
            ->success()
            ->send();

        $this->redirect(static::getResource()::getUrl('index'));
    }

    public function reject(): void
    {
        $this->record->update([
            'status' => 'rejected',
            'approved_or_rej_by' => Auth::id(),
            'approved_or_rej_at' => Carbon::now(),
        ]);

        Notification::make()
            ->title(__('f28.rejected_successfully'))
            ->success()
            ->send();

        $this->redirect(static::getResource()::getUrl('index'));
    }
}
