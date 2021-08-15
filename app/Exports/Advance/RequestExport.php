<?php

namespace App\Exports\Advance;

use App\Models\Projects\Request;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RequestExport implements FromView, ShouldAutoSize
{
    use Exportable;
    
    protected $start_date;
    protected $end_date;

    public function __construct(string $start_date, string $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function view(): View
    {
        $periodeAwal = Carbon::parse($this->start_date)->format('Y-m-d');
        $periodeAkhir = Carbon::parse($this->end_date)->format('Y-m-d');
        $results = Request::where([
                        ['transaction_date','>=',Carbon::parse($periodeAwal)->format('Y-m-d')],
                        ['transaction_date','<=',Carbon::parse($periodeAkhir)->format('Y-m-d')]
                    ])
                    ->get();

        $setting = setSetting();
        return view('reports.advance.request.excel', [
            'results' => $results,
            'setting' => $setting,
            'title' => 'Daftar Advance',
            'periodeAwal' => $periodeAwal,
            'periodeAkhir' => $periodeAkhir,
        ]);
    }
}
