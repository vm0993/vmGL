<?php

namespace App\Observers\Accountings;

use App\Models\Accounting\JurnalDetail;

class JurnalDetailObserver
{
    private function generateTotal($jurnalDetail)
    {
        //MENGAMBIL Jurnal ID
        $jurnalDetail_id = $jurnalDetail->jurnal_id;
        //SELECT DARI TABLE quotation_details BERDASARKAN Quotation
        $jurnal_detail = JurnalDetail::where('jurnal_id', $jurnalDetail_id)->get();
        //KEMUDIAN DIJUMLAH UNTUK MENDAPATKAN TOTALNYA
        $totalJurnal = $jurnal_detail->sum(function($i) {
            //DIMANA KETENTUAN YANG DIJUMLAHKAN ADALAH HASIL DARI price* qty
            return $i->debet;
        });

        //UPDATE TABLE quotation PADA FIELD TOTAL
        $jurnalDetail->jurnalHeader()->update([
            'total' => $totalJurnal
        ]);
        
    }

    public function created(JurnalDetail $jurnalDetail)
    {
        $this->generateTotal($jurnalDetail);
    }

    public function updated(JurnalDetail $jurnalDetail)
    {
        $this->generateTotal($jurnalDetail);
    }

    public function deleted(JurnalDetail $jurnalDetail)
    {
        $this->generateTotal($jurnalDetail);
    }
}
