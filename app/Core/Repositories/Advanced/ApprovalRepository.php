<?php

namespace App\Core\Repositories\Advanced;

use App\Core\Interfaces\Advance\ApproveRequestInterface;
use App\Jobs\Advance\ApproveJob;
use App\Models\Advance\RequestAdvance;
use App\Models\Advance\RequestAdvanceDetail;
use App\Models\Advance\RequestApprove;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ApprovalRepository implements ApproveRequestInterface
{
    public function getAll()
    {
        $results = RequestAdvance::select(DB::raw("request_advances.id,request_advances.personel_id,personels.name as pic_name,request_advances.code,request_advances.transaction_date,
                    request_advances.description,request_advances.request_amount,request_advances.amount_approve,request_advances.status,users.name as usercreate,
                    if(request_advances.created_at=request_advances.updated_at,'',request_advances.updated_at) as submitdate,
                    ifnull((select users.name from request_approves join users on request_approves.user_id=users.id where request_advance_id=request_advances.id),'') as userapprove,
                    ifnull((select created_at from request_approves where request_advance_id=request_advances.id),'') as approvedate"))
                    ->join('users','users.id','=','request_advances.created_by')
                    ->join('personels','personels.id','=','request_advances.personel_id')
                    ->where('request_advances.status','SUBMIT')
                    ->paginate(10);
                    
        $results->getCollection()->transform(function ($items) {
            return $this->response($items);
        });

        return $results;
    }

    public function getNextNumber($value)
    {
        return RequestApprove::getAdvRequestNo($value);
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

        $reqAdvance = RequestApprove::create($data);
        
        foreach (request('nomor') as $key => $count) {
            $totAmount =  request('amount_'.$count);

            $dataDetail = [
                'request_advance_id' => $reqAdvance->id,
                'job_order_id'       => request('job_order_'.$count),
                'amount'             => ($totAmount),
                'note'               => request('memo_'.$count),
            ];
            RequestAdvanceDetail::create($dataDetail);
        }
        return $reqAdvance;
    }

    public function update($request, $id)
    {
        $jurnal = RequestApprove::find($id);
        $jurnal->update($request->all());
        
        return $jurnal; 
    }

    public function delete($id)
    {
        $jurnal = RequestApprove::find($id);
        $jurnal->delete();

        return $jurnal;
    }

    public function approveRequest($id)
    {
        $reqAdvance         = RequestAdvance::find($id);
        $reqAdvance->status = 'APPROVED';
        $reqAdvance->save();
        //$verUser = $userVer->email;
        //Detail Email Content via Job Queue
        $details = [
            //'to'       => $userVer->email,
            'request'  => $reqAdvance,
            'subject'  => 'Approve Request Ops No '. $reqAdvance->code,
            'requests' => RequestAdvanceDetail::with('jobOrder')->where('request_advance_id',$id)->get(),
            'user'     => auth()->user()->name,
        ];
        //Send Email via Job Queue
        ApproveJob::dispatch($details);
    }

    public function previewApproveRequestForm($id)
    {
        
    }

    public function singleResponse($advance)
    {
        return [
            'id'               => $advance->id,
            'code'             => $advance->code,
            'personel_id'      => $advance->personel_id,
            'personel'         => $advance->pic_name,
            'transaction_date' => $advance->transaction_date,
            'trans_date'       => Carbon::parse($advance->transaction_date)->format('d M Y'),
            'description'      => $advance->description,
            'request_amount'   => number_format($advance->request_amount),
            'approve_amount'   => number_format($advance->approve_amount),
            'trans_date'       => Carbon::parse($advance->transaction_date)->format('d M Y'),
            'trans_date'       => Carbon::parse($advance->transaction_date)->format('d M Y'),
        ];
    }

    public function response($advance)
    {
        return [
            'id'               => $advance->id,
            'code'             => $advance->code,
            'personel'         => $advance->pic_name,
            'transaction_date' => $advance->transaction_date,
            'trans_date'       => Carbon::parse($advance->transaction_date)->format('d M Y'),
            'description'      => $advance->description,
            'request_amount'   => number_format($advance->request_amount),
            'approve_amount'   => number_format($advance->approve_amount),
            'status'           => $advance->status,
            'created_by'       => $advance->created_by,
            'usercreate'       => $advance->usercreate,
            'userapprove'      => $advance->userapprove,
            'submitdate'       => Carbon::parse($advance->submitdate)->format('d M y'),
            'approvedate'      => Carbon::parse($advance->approvedate)->format('d M y'),
        ];
    }

    public function getData($code)
    {
        return RequestApprove::where('code',$code)->get();
    }

    public function download($format)
    {
        return response()->download('report_title',$format);
    }
}