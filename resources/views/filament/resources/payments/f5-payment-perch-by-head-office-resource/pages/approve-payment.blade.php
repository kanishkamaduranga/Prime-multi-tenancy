<x-filament-panels::page>
    <div class="my-4">
        <x-filament::card>
            @include('filament.widgets.payment-details-view', ['record' => $record])
        </x-filament::card>
    </div>
</x-filament-panels::page>
