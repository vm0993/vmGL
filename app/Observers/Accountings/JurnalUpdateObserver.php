<?php

namespace App\Observers\Accountings;

use App\Models\Accounting\GeneralLedger;
use App\Models\Accounting\GeneralLedgerDetail;
use App\Models\Accounting\Jurnal;
use App\Models\Accounting\JurnalDetail;

class JurnalUpdateObserver
{
    public function generatePostingJurnal($jurnal)
    {
        $gl_id = Jurnal::findOrFail('id',$jurnal->id);
        //dd($gl_id);
        $data = [
            'module_id' => 12,
            'code' => $gl_id->code,
            'transaction_date' => $gl_id->transaction_date,
            'description' => $gl_id->description,
            'amount' => $gl_id->total,
            'created_by' => $gl_id->created_by,
            'updated_by' => $gl_id->updated_by,
        ];

        $gl = GeneralLedger::where('code',$jurnal->code)->first();
        if(empty($gl)){
            $glHeader = GeneralLedger::create($data);
            $glID = $glHeader->id;
        }else{
            $gl->update($data);
            GeneralLedgerDetail::where('general_ledger_id',$gl->id)->delete();
            $glID = $gl->id;
        }

        $glDetail = JurnalDetail::where('jurnal_id',$gl_id)->get();
        foreach($glDetail as $detail)
        {
            $transDetail = [
                'general_ledger_id' => $glHeader->id,
                'account_id' => $detail->account_id,
                'cost_id' => $detail->cost_id,
                'debet' => $detail->debet,
                'credit' => $detail->credit,
                'memo' => $detail->memo,
            ];
            GeneralLedgerDetail::create($transDetail);
        }
    }

    public function updated(Jurnal $jurnal)
    {
        $this->generatePostingJurnal($jurnal);
    }
}
