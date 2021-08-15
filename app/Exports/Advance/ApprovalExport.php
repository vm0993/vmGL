<?php

namespace App\Exports\Advance;

use App\Mail\Advance\ReleaseAdvance;
use App\Models\Advanced\Request;
use App\Models\Projects\Report;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ApprovalExport implements FromView, ShouldAutoSize
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
                        ['transaction_date','<=',Carbon::parse($periodeAkhir)->format('Y-m-d')],
                        ['status',3],
                    ])
                    ->get();

        $setting = setSetting();
        return view('reports.advance.approvals.excel', [
            'results' => $results,
            'setting' => $setting,
            'title' => 'Daftar Approval Request',
            'periodeAwal' => $periodeAwal,
            'periodeAkhir' => $periodeAkhir,
        ]);
    }
}
