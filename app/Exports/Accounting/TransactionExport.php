<?php

namespace App\Exports\Accounting;

use App\Models\Accounting\GeneralLedger;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TransactionExport implements FromView, ShouldAutoSize
{
    use Exportable;
    
    protected $start_date;
    protected $end_date;

    public function __construct(string $start_date, string $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function view(): View
    {
        $periodeAwal = Carbon::parse($this->start_date)->format('Y-m-d');
        $periodeAkhir = Carbon::parse($this->end_date)->format('Y-m-d');
        $results = GeneralLedger::select(DB::raw('general_ledgers.id,general_ledgers.module_id,general_ledgers.code,general_ledgers.transaction_date,accounts.account_no,
                    accounts.account_name,ifnull((select code from projects where id=general_ledger_details.cost_id),"") as costid,general_ledger_details.debet,general_ledger_details.credit,general_ledger_details.memo '))
                    ->join('general_ledger_details','general_ledger_details.general_ledger_id','=','general_ledgers.id')
                    ->join('accounts','accounts.id','=','general_ledger_details.account_id')
                    ->where([
                        ['general_ledgers.transaction_date','>=',Carbon::parse($periodeAwal)->format('Y-m-d')],
                        ['general_ledgers.transaction_date','<=',Carbon::parse($periodeAkhir)->format('Y-m-d')]
                    ]);
        
        $sqlResults = GeneralLedger::select(DB::raw('a.id,a.module_id,a.code,a.transaction_date,a.account_no,a.account_name,a.costid,a.debet,a.credit,a.memo'))
                    ->from(DB::raw('('.$results->toSql().') as a '))
                    ->mergeBindings($results->getQuery())
                    ->get();

        $setting = setSetting();
        return view('reports.accountings.history-jurnals.excel', [
            'results' => $sqlResults,
            'setting' => $setting,
            'title' => 'Daftar Histori Jurnal',
            'periodeAwal' => $periodeAwal,
            'periodeAkhir' => $periodeAkhir,
        ]);
    }
}
