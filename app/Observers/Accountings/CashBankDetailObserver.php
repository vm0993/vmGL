<?php

namespace App\Observers\Accountings;

use App\Models\Accounting\Accounts\AccountBalance;
use App\Models\Accounting\CashBanks\CashBank;
use App\Models\Accounting\CashBanks\CashBankDetail;

class CashBankDetailObserver
{
    private function generateTotal($cashBankDetail)
    {
        $cashBankID = $cashBankDetail->cash_bank_id;
        $jurnalAccountId = $cashBankDetail->account_id;
        $cashBanks = CashBankDetail::where('cash_bank_id', $cashBankID)->get();
        
        $cashbank = CashBank::find($cashBankID);

        //update from detail transaction
        $accBalDetail = AccountBalance::where([
                            ['transaction_date',$cashbank->transaction_date],
                            ['account_id',$cashBankDetail->account_id]
                        ])
                        ->first();
                        
        if($accBalDetail){
            //if record exists
            $data = [
                'debet_amount'     => $accBalDetail->debet_amount + ($cashbank->transaction_id == 0 ? $cashBankDetail->amount : 0 ),
                'credit_amount'    => $accBalDetail->credit_amount + ($cashbank->transaction_id == 1 ? $cashBankDetail->amount : 0 ),
            ];
            $accBalDetail->update($data);
        }else{
            //new record
            $data = [
                'account_id'       => $cashBankDetail->account_id,
                'transaction_date' => $cashbank->transaction_date,
                'debet_amount'     => ($cashbank->transaction_id == 0 ? $cashBankDetail->amount : 0 ) ,
                'credit_amount'    => ($cashbank->transaction_id == 1 ? $cashBankDetail->amount : 0 ),
            ];
            AccountBalance::create($data);
        }

        //update from header transaction
        $accBalHeader = AccountBalance::where([
                            ['transaction_date',$cashbank->transaction_date],
                            ['account_id',$cashbank->account_id]
                        ])
                        ->first();
                
        if($accBalHeader){
            $data = [
                'debet_amount'     => $accBalHeader->debet_amount + ($cashbank->transaction_id == 1 ? $cashBankDetail->amount : 0 ),
                'credit_amount'    => $accBalHeader->credit_amount + ($cashbank->transaction_id == 0 ? $cashBankDetail->amount : 0 ),
            ];
            $accBalHeader->update($data);
        }else{
            $data = [
                'account_id'       => $cashbank->account_id,
                'transaction_date' => $cashbank->transaction_date,
                'debet_amount'     => ($cashbank->transaction_id == 1 ? $cashBankDetail->amount : 0) ,
                'credit_amount'    => ($cashbank->transaction_id == 0 ? $cashBankDetail->amount : 0 ),
            ];
            AccountBalance::create($data);
        }

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
