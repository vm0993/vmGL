<?php

namespace App\Exports\Accounting;

use App\Models\Accounting\Bank;
use App\Models\Accounting\GeneralLedger;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BankExport implements FromView, ShouldAutoSize
{
    use Exportable;

    /* protected $start_date;
    protected $end_date; */

    public function view(): View
    {
        $results = Bank::all();

        $setting = setSetting();
        return view('reports.accountings.banks.excel', [
            'results' => $results,
            'setting' => $setting,
            'title' => 'Daftar Bank',
        ]);
    }
}
