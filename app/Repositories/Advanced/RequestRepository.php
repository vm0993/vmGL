<?php

namespace App\Repositories\Advanced;

use App\Http\Requests\Advance\AdvanceRequest;
use App\Interfaces\AppInterface;
use Carbon\Carbon;

class RequestRepository implements AppInterface
{
    public function getAll()
    {
        $jurnals = AdvanceRequest::orderBy('code','desc')
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
        return AdvanceRequest::getJurnalNo($value);
    }

    public function getById($value)
    {
    }

    public function findById($id)
    {
        $jurnal = AdvanceRequest::find($id);
        return $this->response($jurnal);
    }

    public function create($request)
    {
        $jurnal = AdvanceRequest::create($request->all());
        
        return $jurnal;    
    }

    public function update($request, $id)
    {
        $jurnal = AdvanceRequest::find($id);
        $jurnal->update($request->all());
        
        return $jurnal; 
    }

    public function delete($id)
    {
        $jurnal = AdvanceRequest::find($id);
        $jurnal->delete();

        return $jurnal;
    }

    public function response($jurnal)
    {
        return [
            'id' => $jurnal->id,
            'code' => $jurnal->code,
            'transaction_date'  => $jurnal->transaction_date,
            'trans_date'  => Carbon::parse($jurnal->transaction_date)->format('d M Y'),
            'description' => $jurnal->description,
            'total' => number_format($jurnal->total),
            'status' => $jurnal->status,
            'created_by' => $jurnal->created_by,
            'user_name' => $jurnal->user->name,
            'created_at' => Carbon::parse($jurnal->created_at)->format('d M Y h:m:s A'),
            'updated_at' => Carbon::parse($jurnal->updated_at)->format('d M Y h:m:s A'),
        ];
    }

    public function getData($code)
    {
        return AdvanceRequest::where('code',$code)->get();
    }

    public function download($format)
    {
        return response()->download('report_title',$format);
    }
}