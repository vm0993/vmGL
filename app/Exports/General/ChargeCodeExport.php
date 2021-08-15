<?php

namespace App\Exports\General;

use App\Models\General\Service;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ChargeCodeExport implements FromView, ShouldAutoSize
{
    use Exportable;

    public function view(): View
    {
        $results = Service::with('category')->get();

        $setting = setSetting();
        return view('reports.generals.charge-codes.excel', [
            'results' => $results,
            'setting' => $setting,
            'title' => 'Daftar Charge Code'
        ]);
    }
}
