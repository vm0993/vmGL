<?php

namespace App\Core\Repositories\Accounting;

use App\Core\Interfaces\Accounting\CashBankInterface;
use App\Models\Accounting\CashBanks\CashBank;
use App\Models\Accounting\CashBanks\CashBankDetail;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CashBankRepository implements CashBankInterface
{
    public function getAll()
    {
        $cashBanks = CashBank::with('account')
                    ->orderBy('code','desc')
                    ->paginate(10);

        $cashBanks->getCollection()->transform(function ($items) {
            return $this->response($items);
        });

        return $cashBanks;
    }

    public function getNextNumber($value, $tipe)
    {
        return CashBank::getCashBankNo($value, $tipe);
    }

    public function getById($value)
    {
        $transactions = CashBankDetail::where('cash_bank_id',$value)->get();

        return $transactions;
    }
    
    public function findById($id)
    {
        $cashBank = CashBank::with('cashBankDetail')->find($id);

        $data = [
            'cashbank'  => $this->singleResponse($cashBank),
            'details'   => $cashBank['cashBankDetail'],
        ];
        
        return $data;
    }

    public function create($request)
    {
        $data = [
            'code'             => $request->voucher_no,
            'transaction_id'   => $request->cashbank_tipe == 'on' ? 1 : 0,
            'transaction_date' => Carbon::parse(Str::replace('_','',$request->transaction_date))->format('Y-m-d'),
            'description'      => $request->description,
            'account_id'       => $request->account_id,
        ];

        $cashBank = CashBank::create($data);
        
        foreach (request('nomor') as $key => $count) {
            $totAmount =  request('amount_'.$count);

            $dataDetail = [
                'cash_bank_id' => $cashBank->id,
                'account_id'   => request('account_id_'.$count),
                'amount'       => ($totAmount),
                'memo'         => request('memo_'.$count),
            ];
            CashBankDetail::create($dataDetail);
        }
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
            'id'               => $cashBank->id,
            'account_id'       => $cashBank->account_id,
            'account_name'     => $cashBank->account->account_name,
            'code'             => $cashBank->code,
            'transaction_date' => $cashBank->transaction_date,
            'trans_date'       => Carbon::parse($cashBank->transaction_date)->format('d M Y'),
            'description'      => $cashBank->description,
            'total'            => number_format($cashBank->total),
            'status'           => $cashBank->status,
            'created_by'       => $cashBank->created_by,
            'user_name'        => $cashBank->user->name,
            'created_at'       => Carbon::parse($cashBank->created_at)->format('d M Y h:m:s A'),
            'updated_at'       => Carbon::parse($cashBank->updated_at)->format('d M Y h:m:s A'),
        ];
    }

    public function singleResponse($cashBank)
    {
        return [
            'id'               => $cashBank->id,
            'transaction_id'   => $cashBank->transaction_id,
            'code'             => $cashBank->code,
            'account_id'       => $cashBank->account_id,
            'transaction_date' => $cashBank->transaction_date,
            'trans_date'       => Carbon::parse($cashBank->transaction_date)->format('d M Y'),
            'description'      => $cashBank->description,
        ];
    }

    public function multipleResponse($cashBank)
    {
        return [
            'id'           => $cashBank->id,
            'cash_bank_id' => $cashBank->cash_bank_id,
            'account_id'   => $cashBank->account_id,
            'amount'       => $cashBank->amount,
            'memo'         => $cashBank->memo,
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