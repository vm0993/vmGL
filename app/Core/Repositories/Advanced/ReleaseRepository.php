<?php

namespace App\Core\Repositories\Advanced;

use App\Core\Interfaces\Advance\ReleaseInterface;
use App\Core\Interfaces\Advance\ReleaseRequestInterface;
use App\Jobs\Advance\ReleaseJob;
use App\Models\Advance\RequestAdvance;
use App\Models\Advance\RequestRelease;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ReleaseRepository implements ReleaseRequestInterface
{
    public function getAll()
    {
        $results = RequestRelease::orderBy('code','desc')
                    ->paginate(10);
                    
        $results->getCollection()->transform(function ($items) {
            return $this->response($items);
        });

        return $results;
    }

    public function getNextNumber($value)
    {
        return RequestRelease::getAdvRequestNo($value);
    }

    public function getById($id)
    {
        $transactions = RequestRelease::where('id',$id)->get();
        
        return $transactions;
    }

    public function findById($id)
    {
        $release = RequestRelease::with('advanced')->find($id);
        
        $data = [
            'release' => $this->singleResponse($release),
            'details' => $release['advanced'],
        ];
        
        return $data;
    }

    public function create($request)
    {
        $data = [
            'code'               => $request->voucher_no,
            'account_id'         => $request->account_id,
            'request_advance_id' => $request->request_advance_id,
            'transaction_date'   => Carbon::parse(Str::replace('_','',$request->transaction_date))->format('Y-m-d'),
            'description'        => $request->description,
        ];

        $release = RequestRelease::create($data);
        
        return $release;
    }

    public function update($request, $id)
    {
        $data = [
            'code'               => $request->voucher_no,
            'account_id'         => $request->account_id,
            'request_advance_id' => $request->request_advance_id,
            'transaction_date'   => Carbon::parse(Str::replace('_','',$request->transaction_date))->format('Y-m-d'),
            'description'        => $request->description,
        ];

        $release = RequestRelease::find($id);
        $release->update($data);
        
        return $release; 
    }

    public function delete($id)
    {
        $release = RequestRelease::find($id);
        $release->delete();

        return $release;
    }

    public function releaseRequest($id)
    {
        $reqAdvance         = RequestAdvance::find($id);
        $reqAdvance->status = 'RELEASE';
        $reqAdvance->save();
        //$verUser = $userVer->email;
        //Detail Email Content via Job Queue
        $details = [
            //'to'       => $userVer->email,
            'request'  => $reqAdvance,
            'subject'  => 'Release Request Ops No '. $reqAdvance->code,
            'user'     => auth()->user()->name,
        ];
        //Send Email via Job Queue
        ReleaseJob::dispatch($details);
    }

    public function previewReleaseRequestForm($id)
    {
        
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
        return RequestRelease::where('code',$code)->get();
    }

    public function download($format)
    {
        return response()->download('report_title',$format);
    }
}