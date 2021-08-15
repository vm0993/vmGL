<?php

namespace App\Observers\Advances;

use App\Models\Advanced\RequestDetail;

class AdvanceDetailObserver
{
    private function generateTotal($advanceDetail)
    {
        //MENGAMBIL Jurnal ID
        $advanceRequestID = $advanceDetail->request_id;
        //SELECT DARI TABLE quotation_details BERDASARKAN Quotation
        $reportingDetail = RequestDetail::where('request_id', $advanceRequestID)->get();
        //KEMUDIAN DIJUMLAH UNTUK MENDAPATKAN TOTALNYA
        $totalAdvance = $reportingDetail->sum(function($i) {
            //DIMANA KETENTUAN YANG DIJUMLAHKAN ADALAH HASIL DARI price* qty
            return $i->amount;
        });

        //UPDATE TABLE quotation PADA FIELD TOTAL
        $advanceDetail->requestHeader()->update([
            'request_amount' => $totalAdvance
        ]);
    }

    public function created(RequestDetail $advanceDetail)
    {
        $this->generateTotal($advanceDetail);
    }

    public function updated(RequestDetail $advanceDetail)
    {
        $this->generateTotal($advanceDetail);
    }

    public function deleted(RequestDetail $advanceDetail)
    {
        $this->generateTotal($advanceDetail);
    }
}
