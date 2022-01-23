<?php

namespace App\Repositories\Accounting;

use App\Interfaces\AppInterface;
use App\Models\Accounting\CashBanks\CashBank;
use Carbon\Carbon;

class CashBankRepository implements AppInterface
{
    public function getAll()
    {
        $cashBanks = CashBank::orderBy('code','desc')
                    ->paginate(10);

        $cashBanks->getCollection()->transform(function ($items) {
            return $this->response($items);
        });

        return $cashBanks;
    }

    public function getNextNumber($value)
    {
    }

    public function getById($value)
    {
    }
    
    public function findById($id)
    {
        $cashBank = CashBank::find($id);
        return $this->response($cashBank);
    }

    public function create($request)
    {
        $cashBank = CashBank::create($request->all());
        
        return $cashBank;    
    }

    public function update($request, $id)
    {
        $cashBank = CashBank::find($id);
        $cashBank->update($request->all());
        
        return $cashBank; 
    }

    public function delete($id)
    {
        $cashBank = CashBank::find($id);
        $cashBank->delete();

        return $cashBank;
    }

    public function response($cashBank)
    {
        return [
            'id' => $cashBank->id,
            'account_id' => $cashBank->account_id,
            'account_name' => $cashBank->account->account_name,
            'code' => $cashBank->code,
            'transaction_date'  => $cashBank->transaction_date,
            'trans_date'  => Carbon::parse($cashBank->transaction_date)->format('d M Y'),
            'description' => $cashBank->description,
            'total' => number_format($cashBank->total),
            'status' => $cashBank->status,
            'created_by' => $cashBank->created_by,
            'user_name' => $cashBank->user->name,
            'created_at' => Carbon::parse($cashBank->created_at)->format('d M Y h:m:s A'),
            'updated_at' => Carbon::parse($cashBank->updated_at)->format('d M Y h:m:s A'),
        ];
    }

    public function getData($code)
    {
        return CashBank::where('code',$code)->get();
    }

    public function download($format)
    {
        return response()->download('report_title',$format);
    }
}