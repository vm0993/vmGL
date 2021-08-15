<?php

namespace App\Http\Livewire\Accounting\HistoryJurnal;

use App\Exports\Accounting\TransactionExport;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\Accounting\GeneralLedger;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class HistoryJurnal extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;
    
    public $jurnal, $code, $transaction_date, $description, $total, $status, $jurnal_id;
    public $settings;
    public $updateMode = 0;
    public $showFilters = false;
    public $confirmingDeletion = false;
    protected $queryString = ['sorts'];
    public $filters = [
        'search' => '',
        'start_date' => '',
        'end_date' => '',
        'code' => '',
        'account_name' => '',
    ];

    public function updatedFilters() { $this->resetPage(); }

    public function toggleShowFilters()
    {
        $this->useCachedRows();
        $this->showFilters = ! $this->showFilters;
    }

    public function resetFilters() { $this->reset('filters'); }

    public function getRowsQueryProperty()
    {
        $results = GeneralLedger::select(DB::raw('general_ledgers.id,general_ledgers.module_id,general_ledgers.code,general_ledgers.transaction_date,accounts.account_no,
                    accounts.account_name,ifnull((select code from projects where id=general_ledger_details.cost_id),"") as costid,general_ledger_details.debet,general_ledger_details.credit,general_ledger_details.memo '))
                    ->join('general_ledger_details','general_ledger_details.general_ledger_id','=','general_ledgers.id')
                    ->join('accounts','accounts.id','=','general_ledger_details.account_id');
        
        $sqlResults = GeneralLedger::select(DB::raw('a.id,a.module_id,a.code,a.transaction_date,a.account_no,a.account_name,a.costid,a.debet,a.credit,a.memo'))
                    ->from(DB::raw('('.$results->toSql().') as a '))
                    ->mergeBindings($results->getQuery());

        $query = $sqlResults
            ->when($this->filters['code'], fn($query, $code) => $query->where('code', 'like', '%'.$code.'%'))
            ->when($this->filters['account_name'], fn($query, $account_name) => $query->where('a.account_name', 'like', '%'.$account_name.'%'))
            ->when($this->filters['start_date'], fn($query, $startDate) => $query->where('a.transaction_date', '>=', ''.$startDate.''))
            ->when($this->filters['end_date'], fn($query, $endDate) => $query->where('a.transaction_date', '<=', ''.$endDate.''))
            ->when($this->filters['search'], fn($query, $search) => $query->where('a.memo', 'like', '%'.$search.'%'));

        return $this->applySorting($query);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.accounting.history-jurnal.history-jurnal',[
            'results' => $this->rows,
        ]);
    }

    public function downloadExcel()
    {
        return Excel::download(new TransactionExport($this->filters['start_date'], $this->filters['end_date']),'Histori Transaction List.xlsx');
    }

    public function downloadPDF()
    {
        $results = GeneralLedger::select(DB::raw('general_ledgers.id,general_ledgers.module_id,general_ledgers.code,general_ledgers.transaction_date,accounts.account_no,
                    accounts.account_name,ifnull((select code from projects where id=general_ledger_details.cost_id),"") as costid,general_ledger_details.debet,general_ledger_details.credit,general_ledger_details.memo '))
                    ->join('general_ledger_details','general_ledger_details.general_ledger_id','=','general_ledgers.id')
                    ->join('accounts','accounts.id','=','general_ledger_details.account_id')
                    ->where([
                        ['general_ledgers.transaction_date','>=',Carbon::parse($this->filters['start_date'])->format('Y-m-d')],
                        ['general_ledgers.transaction_date','<=',Carbon::parse($this->filters['end_date'])->format('Y-m-d')]
                    ]);
        
        $sqlResults = GeneralLedger::select(DB::raw('a.id,a.module_id,a.code,a.transaction_date,a.account_no,a.account_name,a.costid,a.debet,a.credit,a.memo'))
                    ->from(DB::raw('('.$results->toSql().') as a '))
                    ->mergeBindings($results->getQuery())
                    ->get();

        $title = 'Histori Jurnal';
        $params = [
            'settings' => setSetting(),
            'title'  => $title,
            'results' => $sqlResults,
            'periodeAwal' => $this->filters['start_date'],
            'periodeAkhir' => $this->filters['end_date'],
        ];
        $pdf = PDF::loadView('reports.accountings.history-jurnals.list', $params)->output();
        return response()->streamDownload(
            fn () => print($pdf),
            $title.'.pdf'
        );
    }
}
