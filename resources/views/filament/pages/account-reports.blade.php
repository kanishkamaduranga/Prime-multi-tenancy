<x-filament::page>
    {{ $this->form }}

    <div class="mt-4 flex gap-2">
        <x-filament::button
            wire:click="generateReport"
            color="success"
            icon="heroicon-o-arrow-down-tray"
            type="button"
        >
            Generate Report
        </x-filament::button>

        <x-filament::button
            wire:click="resetForm"
            type="button"

            icon="heroicon-o-arrow-path"
        >
            Reset
        </x-filament::button>
    </div>
</x-filament::page>
