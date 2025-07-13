<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\{Select, Checkbox, CheckboxList, Grid};
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AccountReportExport;

class AccountReports extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;


    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'basic_notes';
    protected static string $view = 'filament.pages.account-reports';
    protected static ?int $navigationSort = 12;

    public ?array $data = [];

    public static function getModelLabel(): string
    {
        return trans('f28.account_report');
    }

    public function getTitle(): string
    {
        return __('f28.account_report');
    }

    public static function getNavigationLabel(): string
    {
        return trans('f28.account_report');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('f28.account_report');
    }

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(2)->schema([
                Select::make('departments')
                    ->label(__('f28.Departments'))
                    ->options(fn () => DB::table('departments')->pluck('department', 'id'))
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->required(),

                Checkbox::make('select_all_departments')
                    ->label(__('f28.select_all_departments'))
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set) =>
                    $set('departments', $state ? DB::table('departments')->pluck('id')->toArray() : [])
                    ),

                Select::make('basic_accounts')
                    ->label(__('f28.basic_accounts'))
                    ->options(fn () => \App\Helpers\ImportantParameterHelper::getValues('basic_accounts'))
                    ->multiple()
                    ->required(),

                Checkbox::make('select_all_basic_accounts')
                    ->label(__('f28.select_all_basic_accounts'))
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set) =>
                    $set('basic_accounts', $state ? array_keys(\App\Helpers\ImportantParameterHelper::getValues('basic_accounts')) : [])
                    ),

                Select::make('account_segments')
                    ->label(__('f28.account_segments'))
                    ->multiple()
                    ->options(function (callable $get) {
                        return DB::table('account_segments')
                            ->when($get('departments'), fn ($q) => $q->whereIn('department_id', $get('departments')))
                            ->when($get('basic_accounts'), fn ($q) => $q->whereIn('basic_account', $get('basic_accounts')))
                            ->pluck('account_name', 'id');
                    }),

                Checkbox::make('select_all_account_segments')
                    ->label(__('f28.select_all_account_segments'))
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        if ($state) {
                            $segments = DB::table('account_segments')
                                ->when($get('departments'), fn ($q) => $q->whereIn('department_id', $get('departments')))
                                ->when($get('basic_accounts'), fn ($q) => $q->whereIn('basic_account', $get('basic_accounts')))
                                ->pluck('id')
                                ->toArray();
                            $set('account_segments', $segments);
                        }
                    }),

                Select::make('sub_account_segments')
                    ->label(__('f28.sub_account_segments'))
                    ->multiple()
                    ->options(fn (callable $get) =>
                    DB::table('sub_account_segments')
                        ->when($get('account_segments'), fn ($q) => $q->whereIn('account_segment_id', $get('account_segments')))
                        ->pluck('sub_account_name', 'id')
                    ),

                Checkbox::make('select_all_sub_account_segments')
                    ->label(__('f28.select_all_sub-account_segments'))
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set, callable $get) =>
                    $set('sub_account_segments', $state
                        ? DB::table('sub_account_segments')
                            ->when($get('account_segments'), fn ($q) => $q->whereIn('account_segment_id', $get('account_segments')))
                            ->pluck('id')->toArray()
                        : [])
                    ),

                Checkbox::make('with_all_ledgers')
                    ->label(__('f28.with_all_ledgers')),
            ])
        ])->statePath('data');
    }

    public function generateReport()
    {
        $filters = $this->form->getState();

        return Excel::download(
            new AccountReportExport($filters),
            'account_report_' . now()->format('Ymd_His') . '.xlsx'
        );
    }

    public function resetForm(): void
    {
        $this->form->fill(); // Reset to default values
    }

}
