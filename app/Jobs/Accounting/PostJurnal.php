<?php

namespace App\Jobs\Accounting;

use App\Models\Accounting\GeneralLedger;
use App\Models\Accounting\GeneralLedgerDetail;
use App\Models\Accounting\Jurnal;
use App\Models\Accounting\JurnalDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PostJurnal implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $post = null;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Jurnal $post)
    {
        $this->post = $post;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //to General Ledger
        $gl_id = Jurnal::find($this->post->id);
        dd($gl_id);
        /* $dataUpd = [
            'module_id' => 12,
            'code' => $gl_id->code,
            'transaction_date' => $gl_id->transaction_date,
            'description' => $gl_id->description,
        ];
        
        $glUpdate = GeneralLedger::where('code',$this->post['code'])->first();
        if(empty($glUpdate)){
            $head =  GeneralLedger::create($dataUpd);
        }else{
            $glUpdate->update($dataUpd);
        }
        if(empty($glUpdate)){
            $glID = $head->id;
        }else{
            GeneralLedgerDetail::where('general_ledger_id',$glUpdate->id)->delete();
            $glID = $glUpdate->id;
        }
        $glDetail = JurnalDetail::where('jurnal_id',$gl_id->id)->get();
        foreach($glDetail as $detail)
        {
            $transDetail = [
                'general_ledger_id' => $glID,
                'account_id' => $detail->account_id,
                'cost_id' => $detail->cost_id,
                'debet' => $detail->debet,
                'credit' => $detail->credit,
                'memo' => $detail->memo,
            ];
            GeneralLedgerDetail::create($transDetail);
        }  */
    }
}
