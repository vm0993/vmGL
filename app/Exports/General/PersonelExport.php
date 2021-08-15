<?php

namespace App\Exports\General;

use App\Models\General\Personel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PersonelExport implements FromView, ShouldAutoSize
{
    use Exportable;

    public function view(): View
    {
        $results = Personel::all();

        $setting = setSetting();
        return view('reports.generals.personels.excel', [
            'results' => $results,
            'setting' => $setting,
            'title' => 'Daftar Pegawai'
        ]);
    }
}
