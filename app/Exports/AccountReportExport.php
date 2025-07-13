<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class AccountReportExport implements FromCollection, WithHeadings
{
    protected array $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function collection(): Collection
    {
        return DB::table('ledger_controllers')
            ->when($this->filters['with_all_ledgers'] ?? false, fn($q) => $q->where('type', 'ledger'))
            ->get()
            ->map(function ($item) {
                return [
                    'ID' => $item->id,
                    'Name' => $item->name,
                    'Type' => $item->type,
                ];
            });
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Type'];
    }
}
