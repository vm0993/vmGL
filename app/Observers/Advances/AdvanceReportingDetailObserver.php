<?php

namespace App\Observers\Advances;

use App\Models\Advanced\Request;
use App\Models\Advanced\RequestReporting;
use App\Models\Advanced\RequestReportingDetail;

class AdvanceReportingDetailObserver
{
    private function generateTotal($requestReportingDetail)
    {
        //MENGAMBIL Jurnal ID
        $requestReportingDetail_ID = $requestReportingDetail->request_reporting_id;
        //SELECT DARI TABLE quotation_details BERDASARKAN Quotation
        $reportingDetail = RequestReportingDetail::where('request_reporting_id', $requestReportingDetail_ID)->get();
        //KEMUDIAN DIJUMLAH UNTUK MENDAPATKAN TOTALNYA
        $totalReporting = $reportingDetail->sum(function($i) {
            //DIMANA KETENTUAN YANG DIJUMLAHKAN ADALAH HASIL DARI price* qty
            return $i->amount;
        });

        $requestHead = RequestReporting::find($requestReportingDetail_ID);

        //UPDATE TABLE quotation PADA FIELD TOTAL
        $requestReportingDetail->requestReporting()->update([
            'total' => $totalReporting,
            'balance' => $requestHead->request->amount_approve - $totalReporting,
        ]);
    }

    public function created(RequestReportingDetail $requestReportingDetail)
    {
        $this->generateTotal($requestReportingDetail);
    }

    public function updated(RequestReportingDetail $requestReportingDetail)
    {
        $this->generateTotal($requestReportingDetail);
    }

    public function deleted(RequestReportingDetail $requestReportingDetail)
    {
        $this->generateTotal($requestReportingDetail);
    }
}
