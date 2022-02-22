<?php

namespace App\Observers\Accountings;

use App\Models\Accounting\Accounts\Account;
use App\Models\Accounting\Accounts\AccountBalance;
use App\Models\Accounting\Jurnals\Jurnal;
use App\Models\Accounting\Jurnals\JurnalDetail;

class JurnalDetailObserver
{
    private function generateTotal($jurnalDetail)
    {
        $jurnalDetail_id = $jurnalDetail->jurnal_id;
        $jurnalAccountId = $jurnalDetail->account_id;
        $jurnal_detail = JurnalDetail::where('jurnal_id', $jurnalDetail_id)->get();
        $jurnal = Jurnal::find($jurnalDetail_id);

        //if($account->account_type < 8 || ($account->account_type > 16 && $account->account_type < 19) || $account->account_type == 20 ){
            //debet (+) asset
        $accBalance = AccountBalance::where([
                            ['transaction_date',$jurnal->transaction_date],
                            ['account_id',$jurnalAccountId]
                        ])
                        ->first();
        if($accBalance){
            $data = [
                'debet_amount'     => $accBalance->debet_amount + $jurnalDetail->debet,
                'credit_amount'    => $accBalance->credit_amount + $jurnalDetail->credit,
            ];
            $accBalance->update($data);
        }else{
            $data = [
                'account_id'       => $jurnalAccountId,
                'transaction_date' => $jurnal->transaction_date,
                'debet_amount'     => $jurnalDetail->debet,
                'credit_amount'    => $jurnalDetail->credit,
            ];
            AccountBalance::create($data);
        }
        /* }else{
            //credit (-) liability, equity & revenue
        } */
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
