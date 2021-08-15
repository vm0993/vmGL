<?php

namespace App\Exports\Accounting;

use App\Models\Accounting\Account;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AccountExport implements FromView, ShouldAutoSize
{
    use Exportable;

    public function view(): View
    {
        $results = Account::all();

        $setting = setSetting();
        return view('reports.accountings.coas.excel', [
            'results' => $results,
            'setting' => $setting,
            'title' => 'Daftar Kode Akun'
        ]);
    }
}
