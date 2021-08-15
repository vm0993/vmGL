<?php

namespace App\Exports\General;

use App\Models\General\Unit;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UnitExport implements FromView, ShouldAutoSize
{
    use Exportable;

    public function view(): View
    {
        $results = Unit::all();

        $setting = setSetting();
        return view('reports.generals.units.excel', [
            'results' => $results,
            'setting' => $setting,
            'title' => 'Daftar Satuan'
        ]);
    }
}
