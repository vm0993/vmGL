<?php

namespace App\Observers\Accountings;

use App\Models\Accounting\Jurnals\JurnalDetail;

class JurnalDetailObserver
{
    private function generateTotal($jurnalDetail)
    {
        $jurnalDetail_id = $jurnalDetail->jurnal_id;
        $jurnalAccountId = $jurnalDetail->account_id;
        $jurnal_detail = JurnalDetail::where('jurnal_id', $jurnalDetail_id)->get();
        
        $totalJurnal = $jurnal_detail->sum(function($i) {
            return $i->debet;
        });

        //UPDATE TABLE JURNAL FIELD TOTAL
        $jurnalDetail->jurnal()->update([
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
