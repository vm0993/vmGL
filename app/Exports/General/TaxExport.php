<?php

namespace App\Exports\General;

use App\Models\General\Tax;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TaxExport implements FromView, ShouldAutoSize
{
    use Exportable;

    public function view(): View
    {
        $results = Tax::all();

        $setting = setSetting();
        return view('reports.generals.taxes.excel', [
            'results' => $results,
            'setting' => $setting,
            'title' => 'Daftar Kode Pajak'
        ]);
    }
}
