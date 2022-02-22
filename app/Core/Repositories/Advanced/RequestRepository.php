<?php

namespace App\Core\Repositories\Advanced;

use App\Core\Interfaces\Advance\RequestInterface;
use App\Core\Interfaces\Advance\RequestSubmitInterface;
use App\Jobs\Advance\ApproveJob;
use App\Jobs\Advance\RequestSubmitJob;
use App\Models\Advance\RequestAdvance;
use App\Models\Advance\RequestAdvanceDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RequestRepository implements RequestSubmitInterface
{
    public function getAll()
    {
        $results = RequestAdvance::orderBy('code','desc')
                    ->paginate(10);
                    
        $results->getCollection()->transform(function ($items) {
            return $this->response($items);
        });

        return $results;
    }

    public function getNextNumber($value)
    {
        return RequestAdvance::getAdvRequestNo($value);
    }

    public function getById($id)
    {
        $transactions = RequestAdvanceDetail::where('request_advance_id',$id)->get();
        
        return $transactions;
    }

    public function findById($id)
    {
        $advance = RequestAdvance::with('advanceDetail')->find($id);
        
        $data = [
            'advance' => $this->singleResponse($advance),
            'details' => $advance['advanceDetail'],
        ];
        
        return $data;
    }

    public function create($request)
    {
        $data = [
            'code'             => $request->voucher_no,
            'personel_id'      => $request->personel_id,
            'transaction_date' => Carbon::parse(Str::replace('_','',$request->transaction_date))->format('Y-m-d'),
            'description'      => $request->description,
        ];

        $reqAdvance = RequestAdvance::create($data);
        
        foreach (request('nomor') as $key => $count) {
            $totAmount =  request('amount_'.$count);
            $output = preg_replace( '/[^0-9]/', '', $totAmount );

            $dataDetail = [
                'request_advance_id' => $reqAdvance->id,
                'job_order_id'       => request('job_order_'.$count),
                'amount'             => $output,
                'note'               => request('memo_'.$count),
            ];
            RequestAdvanceDetail::create($dataDetail);
        }
        return $reqAdvance;
    }

    public function update($request, $id)
    {
        $jurnal = RequestAdvance::find($id);
        $jurnal->update($request->all());
        
        return $jurnal; 
    }

    public function delete($id)
    {
        $jurnal = RequestAdvance::find($id);
        $jurnal->delete();

        return $jurnal;
    }

    public function singleResponse($advance)
    {
        return [
            'id'               => $advance->id,
            'code'             => $advance->code,
            'personel_id'      => $advance->personel_id,
            'transaction_date' => $advance->transaction_date,
            'trans_date'       => Carbon::parse($advance->transaction_date)->format('d M Y'),
            'description'      => $advance->description,
            'request_amount'   => number_format($advance->request_amount),
            'approve_amount'   => number_format($advance->approve_amount),
        ];
    }

    public function response($advance)
    {
        return [
            'id'               => $advance->id,
            'code'             => $advance->code,
            'personel'         => $advance->personel->name,
            'transaction_date' => $advance->transaction_date,
            'trans_date'       => Carbon::parse($advance->transaction_date)->format('d M Y'),
            'description'      => $advance->description,
            'request_amount'   => number_format($advance->request_amount),
            'approve_amount'   => number_format($advance->approve_amount),
            'status'           => $advance->status,
            'created_by'       => $advance->created_by,
            'user_name'        => $advance->user->name,
            'created_at'       => Carbon::parse($advance->created_at)->format('d M Y h:m:s A'),
            'updated_at'       => Carbon::parse($advance->updated_at)->format('d M Y h:m:s A'),
        ];
    }

    public function getData($code)
    {
        return RequestAdvance::where('code',$code)->get();
    }

    public function download($format)
    {
        return response()->download('report_title',$format);
    }

    public function submitRequest($id)
    {
        $reqAdvance         = RequestAdvance::find($id);
        $reqAdvance->status = 'SUBMIT';
        $reqAdvance->save();
        //$verUser = $userVer->email;
        //Detail Email Content via Job Queue
        $details = [
            //'to'       => $userVer->email,
            'request'  => $reqAdvance,
            'subject'  => 'Request for Approved Ops No '. $reqAdvance->code,
            'requests' => RequestAdvanceDetail::with('jobOrder')->where('request_advance_id',$id)->get(),
            'user'     => auth()->user()->name,
        ];
        //Send Email via Job Queue
        RequestSubmitJob::dispatch($details);
    }

    public function previewRequestForm($id)
    {
        
    }

}