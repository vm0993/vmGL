<?php

namespace App\Observers\Accountings;

use App\Models\Accounting\CashBanks\CashBankDetail;

class CashBankDetailObserver
{
    private function generateTotal($cashBankDetail)
    {
        $cashBankID = $cashBankDetail->cash_bank_id;
        $jurnalAccountId = $cashBankDetail->account_id;
        $cashBanks = CashBankDetail::where('cash_bank_id', $cashBankID)->get();
        
        $totalCashBank = $cashBanks->sum(function($i) {
            return $i->amount;
        });

        //UPDATE TABLE JURNAL FIELD TOTAL
        $cashBankDetail->cashBank()->update([
            'total' => $totalCashBank
        ]);
    }

    public function created(CashBankDetail $cashBankDetail)
    {
        $this->generateTotal($cashBankDetail);
    }

    public function updated(CashBankDetail $cashBankDetail)
    {
        $this->generateTotal($cashBankDetail);
    }

    public function deleted(CashBankDetail $cashBankDetail)
    {
        $this->generateTotal($cashBankDetail);
    }
}
