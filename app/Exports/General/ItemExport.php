<?php

namespace App\Exports\General;

use App\Models\General\Item;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ItemExport implements FromView, ShouldAutoSize
{
    use Exportable;

    public function view(): View
    {
        $results = Item::with(['category','unit','tax'])->get();

        $setting = setSetting();
        return view('reports.generals.items.excel', [
            'results' => $results,
            'setting' => $setting,
            'title' => 'Daftar Barang/Jasa'
        ]);
    }
}
