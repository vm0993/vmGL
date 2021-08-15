<?php

namespace App\Observers\Accountings;

use App\Models\Accounting\CashBankDetail;

class CashBankDetailObserver
{
    private function generateTotal($cashBankDetail)
    {
        //MENGAMBIL Jurnal ID
        $cashBankDetail_ID = $cashBankDetail->cash_bank_id;
        //SELECT DARI TABLE quotation_details BERDASARKAN Quotation
        $cashBank_detail = CashBankDetail::where('cash_bank_id', $cashBankDetail_ID)->get();
        //KEMUDIAN DIJUMLAH UNTUK MENDAPATKAN TOTALNYA
        $totalCashBank = $cashBank_detail->sum(function($i) {
            //DIMANA KETENTUAN YANG DIJUMLAHKAN ADALAH HASIL DARI price* qty
            return $i->amount;
        });

        //UPDATE TABLE quotation PADA FIELD TOTAL
        $cashBankDetail->kasbank()->update([
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
