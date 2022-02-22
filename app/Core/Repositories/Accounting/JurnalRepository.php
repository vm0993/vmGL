<?php

namespace App\Core\Repositories\Accounting;

use App\Core\Interfaces\Accounting\JurnalInterface;
use App\Models\Accounting\Jurnals\Jurnal;
use App\Models\Accounting\Jurnals\JurnalDetail;
use Carbon\Carbon;
use Illuminate\Support\Str;

class JurnalRepository implements JurnalInterface
{
    public function getAll()
    {
        $jurnals = Jurnal::orderBy('code','desc')
                    ->when(request()->input('description'), function ($query, $description) {
                        return $query->where('description', 'like', $description = "%{$description}%");
                    })
                    ->when(request()->input('code'), function ($query, $code) {
                        return $query->where('code', 'like' ,"%{$code}%");
                    })
                    ->orderBy('code','desc')
                    ->paginate(10)
                    ->appends(request()->query());

        $jurnals->getCollection()->transform(function ($items) {
            return $this->response($items);
        });

        return $jurnals;
    }

    public function getNextNumber($value)
    {
        return Jurnal::getJurnalNo($value);
    }

    public function getById($value)
    {
        $transactions = JurnalDetail::where('jurnal_id',$value)->get();

        return $transactions;
    }

    public function findById($id)
    {
        $jurnal = Jurnal::with('transDetails')->find($id);

        //dd($jurnal['transDetails']);
        $data = [
            'jurnal'  => $this->singleResponse($jurnal),
            'details' => $jurnal['transDetails'],
        ];
        
        return $data;
    }

    public function create($request)
    {
        $data = [
            'code'             => $request->voucher_no,
            'transaction_date' => Carbon::parse(Str::replace('_','',$request->transaction_date))->format('Y-m-d'),
            'description'      => $request->description,
        ];

        //dd($data);
        $jurnal = Jurnal::create($data);
        
        foreach (request('nomor') as $key => $count) {
            $debAmount =  request('debet_'.$count);
            $creAmount =  request('credit_'.$count);

            $dataDetail = [
                'jurnal_id'  => $jurnal->id,
                'account_id' => request('account_id_'.$count),
                'debet'      => ($debAmount),
                'credit'     => ($creAmount),
                'memo'       => request('memo_'.$count),
            ];
            JurnalDetail::create($dataDetail);
        }
        return $jurnal;   
    }

    public function update($request, $id)
    {
        $jurnal = Jurnal::find($id);
        $jurnal->update($request->all());
        
        return $jurnal; 
    }

    public function delete($id)
    {
        $jurnal = Jurnal::find($id);
        $jurnal->delete();

        return $jurnal;
    }

    public function response($jurnal)
    {
        return [
            'id'               => $jurnal->id,
            'code'             => $jurnal->code,
            'transaction_date' => $jurnal->transaction_date,
            'trans_date'       => Carbon::parse($jurnal->transaction_date)->format('d M Y'),
            'description'      => $jurnal->description,
            'total'            => number_format($jurnal->total),
            'status'           => $jurnal->status,
            'created_by'       => $jurnal->created_by,
            'user_name'        => $jurnal->user->name,
            'created_at'       => Carbon::parse($jurnal->created_at)->format('d M Y h:m:s A'),
            'updated_at'       => Carbon::parse($jurnal->updated_at)->format('d M Y h:m:s A'),
        ];
    }

    public function singleResponse($jurnal)
    {
        return [
            'id'               => $jurnal->id,
            'code'             => $jurnal->code,
            'transaction_date' => $jurnal->transaction_date,
            'trans_date'       => Carbon::parse($jurnal->transaction_date)->format('d M Y'),
            'description'      => $jurnal->description,
        ];
    }

    public function multipleResponse($jurnal)
    {
        return [
            'jurnal_id'  => $jurnal->jurnal_id,
            'account_id' => $jurnal->account_id,
            'debet'      => $jurnal->debet,
            'credit'     => $jurnal->credit,
            'memo'       => $jurnal->memo,
        ];
    }

    public function getData($code)
    {
        return JurnalDetail::where('jurnal_id',$code)->get();
    }

    public function download($format)
    {
        return response()->download('report_title',$format);
    }
}