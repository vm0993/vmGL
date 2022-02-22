<?php

namespace App\Observers\Advances;

use App\Models\Advance\RequestAdvanceDetail;

class AdvanceRequestDetailObserver
{
    private function generateTotal($requestDetail)
    {
        $requestID = $requestDetail->request_advance_id;
        $cashBanks = RequestAdvanceDetail::where('request_advance_id', $requestID)->get();
        
        $totalAdvance = $cashBanks->sum(function($i) {
            return $i->amount;
        });

        //UPDATE TABLE JURNAL FIELD TOTAL
        $requestDetail->advanceHeader()->update([
            'request_amount' => $totalAdvance
        ]);
    }

    public function created(RequestAdvanceDetail $requestDetail)
    {
        $this->generateTotal($requestDetail);
    }

    public function updated(RequestAdvanceDetail $requestDetail)
    {
        $this->generateTotal($requestDetail);
    }

    public function deleted(RequestAdvanceDetail $requestDetail)
    {
        $this->generateTotal($requestDetail);
    }
}
