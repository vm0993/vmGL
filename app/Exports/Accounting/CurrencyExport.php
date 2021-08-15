<?php

namespace App\Exports\Accounting;

use App\Models\Accounting\Currency;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CurrencyExport implements FromView, ShouldAutoSize
{
    use Exportable;

    public function view(): View
    {
        $results = Currency::all();

        $setting = setSetting();
        return view('reports.accountings.currencys.excel', [
            'results' => $results,
            'setting' => $setting,
            'title' => 'Daftar Mata Uang'
        ]);
    }
}
