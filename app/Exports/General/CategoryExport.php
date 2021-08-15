<?php

namespace App\Exports\General;

use App\Models\General\Category;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CategoryExport implements FromView, ShouldAutoSize
{
    use Exportable;

    public function view(): View
    {
        $results = Category::all();

        $setting = setSetting();
        return view('reports.generals.categorys.excel', [
            'results' => $results,
            'setting' => $setting,
            'title' => 'Daftar Kategori'
        ]);
    }
}
