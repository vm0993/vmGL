<?php

namespace App\Exports\Accounting;

use App\Models\Accounting\CashBank;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CashBankExport implements FromView, ShouldAutoSize
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
        $setting = setSetting();
        $periodeAwal = Carbon::parse($this->start_date)->format('Y-m-d');
        $periodeAkhir = Carbon::parse($this->end_date)->format('Y-m-d');
        $results = CashBank::where([
                        ['cash_banks.transaction_date','>=',Carbon::parse($periodeAwal)->format('Y-m-d')],
                        ['cash_banks.transaction_date','<=',Carbon::parse($periodeAkhir)->format('Y-m-d')]
                    ])
                    ->with('cashBank')
                    ->get();
        
        return view('reports.accountings.cashbanks.excel', [
            'results' => $results,
            'setting' => $setting,
            'title' => 'Daftar Transaksi Kas & Bank',
            'periodeAwal' => $periodeAwal,
            'periodeAkhir' => $periodeAkhir,
        ]);
    }
}
