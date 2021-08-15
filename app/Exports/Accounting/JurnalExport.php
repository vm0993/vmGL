<?php

namespace App\Exports\Accounting;

use App\Models\Accounting\GeneralLedger;
use App\Models\Accounting\Jurnal;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class JurnalExport implements FromView, ShouldAutoSize
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
        $results = Jurnal::where([
                        ['jurnals.transaction_date','>=',Carbon::parse($periodeAwal)->format('Y-m-d')],
                        ['jurnals.transaction_date','<=',Carbon::parse($periodeAkhir)->format('Y-m-d')]
                    ])
                    ->with('jurnalDetail')
                    ->get();

        $setting = setSetting();
        return view('reports.accountings.jurnals.excel', [
            'results' => $results,
            'setting' => $setting,
            'title' => 'Daftar Jurnal',
            'periodeAwal' => $periodeAwal,
            'periodeAkhir' => $periodeAkhir,
        ]);
    }
}
