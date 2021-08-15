<?php

namespace App\Observers\Accountings;

use App\Models\Accounting\GeneralLedger;
use App\Models\Accounting\GeneralLedgerDetail;

class GeneralLedgerDetailObserver
{
    private function generateTotal($glDetail)
    {
        //MENGAMBIL Jurnal ID
        $gl_id = $glDetail->general_ledger_id;
        //SELECT DARI TABLE quotation_details BERDASARKAN Quotation
        $glDetailJurnal = GeneralLedgerDetail::where('general_ledger_id', $gl_id)->get();
        //KEMUDIAN DIJUMLAH UNTUK MENDAPATKAN TOTALNYA
        $totalJurnal = $glDetailJurnal->sum(function($i) {
            //DIMANA KETENTUAN YANG DIJUMLAHKAN ADALAH HASIL DARI price* qty
            return $i->debet;
        });

        //UPDATE TABLE quotation PADA FIELD TOTAL
        $glDetail->glHeader()->update([
            'amount' => $totalJurnal
        ]);
    }

    public function created(GeneralLedgerDetail $glDetail)
    {
        $this->generateTotal($glDetail);
    }

    public function updated(GeneralLedgerDetail $glDetail)
    {
        $this->generateTotal($glDetail);
    }

    public function deleted(GeneralLedgerDetail $glDetail)
    {
        $this->generateTotal($glDetail);
    }
}
