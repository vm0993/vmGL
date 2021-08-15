<?php

namespace App\Exports\Advance;

use App\Models\Advanced\ReleaseRequest;
use App\Models\Projects\Request;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReleaseExport implements FromView, ShouldAutoSize
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
        $results = ReleaseRequest::where([
                        ['release_requests.transaction_date','>=',Carbon::parse($periodeAwal)->format('Y-m-d')],
                        ['release_requests.transaction_date','<=',Carbon::parse($periodeAkhir)->format('Y-m-d')]
                    ])
                    ->with(['account','request'])
                    ->get();

        $setting = setSetting();
        return view('reports.advance.releases.excel', [
            'results' => $results,
            'setting' => $setting,
            'title' => 'Daftar Advance Release',
            'periodeAwal' => $periodeAwal,
            'periodeAkhir' => $periodeAkhir,
        ]);
    }
}
