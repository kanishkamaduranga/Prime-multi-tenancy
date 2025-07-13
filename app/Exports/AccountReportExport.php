<?php

namespace App\Exports;

use App\Services\LanguageService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class AccountReportExport implements FromCollection, WithHeadings
{
    protected array $filters;

    protected $locale;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
        $this->locale = LanguageService::getLocale();
    }

    public function collection(): Collection
    {

        \Log::info('Account report', [$this->filters, $this->locale]);

        $basic_account_label = 'label_si';
        switch ($this->locale) {
            case 'si':
                $basic_account_label = 'label_si';
                break;
            case 'en':
                $basic_account_label = 'label_en';
                break;
            case 'ta':
                $basic_account_label = 'label_ta';
                break;
        }

        $departments = $this->filters['departments'] ?? [];
        $basicAccounts = $this->filters['basic_accounts'] ?? [];
        $accountSegments = $this->filters['account_segments'] ?? [];
        $subAccountSegments = $this->filters['sub_account_segments'] ?? [];

        $select_all_departments = $this->filters['select_all_departments'] ?? false;
        $select_all_basic_accounts = $this->filters['select_all_basic_accounts'] ?? false;
        $select_all_account_segments = $this->filters['select_all_account_segments'] ?? false;
        $select_all_sub_account_segments = $this->filters['select_all_sub_account_segments'] ?? false;
        $withLedgers = $this->filters['with_all_ledgers'] ?? false;

        // Build query
        $query = DB::table('account_segments as a')
            ->join('departments as d', 'd.id', '=', 'a.department_id')
            ->join('sub_account_segments as sa', 'sa.account_segment_id', '=', 'a.id')
            ->join('important_parameters as im', function ($join) {
                $join->on('a.basic_account', '=', 'im.slug')
                    ->where('im.key', '=', 'basic_accounts');
            });

        if ($withLedgers) {
            $query->leftJoin('ledger_controllers as l', function ($join) {
                $join->on('l.sub_account_segment_id', '=', 'sa.id')
                    ->where('l.type', '=', 'ledger');
            });
            $query->select(
                'd.department_code',
                'd.department',
                'im.'.$basic_account_label.' as basic_account',
                'a.account_number as account_segment_number',
                'a.account_name as account_segment',
                'sa.sub_account_number as sub_account_number',
                'sa.sub_account_name as sub_account_segment',
                'l.name as ledger_name',
                'l.number as ledger_code'
            );

        } else {

            $query->select(
                'd.department_code',
                'd.department',
                'im.'.$basic_account_label.'  as basic_account',
                'a.account_number as account_segment_number',
                'a.account_name as account_segment',
                'sa.sub_account_number as sub_account_number',
                'sa.sub_account_name as sub_account_segment',
            );
        }

        // Apply filters
        if (!empty($departments) && !$select_all_departments ) {
            $query->whereIn('a.department_id', $departments);
        }

        if (!empty($basicAccounts) && !$select_all_basic_accounts ) {
            $query->whereIn('a.basic_account', $basicAccounts);
        }

        if (!empty($accountSegments) && !$select_all_account_segments) {
            $query->whereIn('a.id', $accountSegments);
        }

        if (!empty($subAccountSegments) && !$select_all_sub_account_segments) {
            $query->whereIn('sa.id', $subAccountSegments);
        }

        return $query->get();

    }

    public function headings(): array
    {
        $withLedgers = $this->filters['with_all_ledgers'] ?? false;

        $headings_list = [
            __('f28.department_code'),
            __('f28.department'),
            __('f28.basic_accounts'),
            __('f28.account_number'),
            __('f28.account_name'),
            __('f28.sub_account_number'),
            __('f28.sub_account_name'),
        ];

        if($withLedgers) {
            $headings_list[] = __('f28.ledger_name');
            $headings_list[] = __('f28.ledger_number');
        }

        return $headings_list;
    }
}
