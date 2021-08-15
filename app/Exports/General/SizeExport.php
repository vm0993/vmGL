<?php

namespace App\Exports\General;

use App\Models\General\Size;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SizeExport implements FromView, ShouldAutoSize
{
    use Exportable;

    public function view(): View
    {
        $results = Size::all();

        $setting = setSetting();
        return view('reports.generals.sizes.excel', [
            'results' => $results,
            'setting' => $setting,
            'title' => 'Daftar Ukuran'
        ]);
    }
}
