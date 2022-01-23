<?php

namespace App\Repositories\Accounting;

use App\Interfaces\AppInterface;
use App\Models\Accounting\Jurnals\Jurnal;
use Carbon\Carbon;

class HistoryRepository implements AppInterface
{
    public function getAll()
    {
        $historys = Jurnal::with('jurnalDetail')
                    ->orderBy('code','desc')
                    ->paginate(10);

        $historys->getCollection()->transform(function ($items) {
            return $this->response($items);
        });

        return $historys;
    }

    public function getNextNumber($value)
    {
    }
    
    public function getById($value)
    {
    }
    
    public function findById($id)
    {
        $history = Jurnal::find($id);
        return $this->response($history);
    }

    public function create($request)
    {
        
    }

    public function update($request, $id)
    {
        
    }

    public function delete($id)
    {
        
    }

    public function response($currencys)
    {
        return [
            'id' => $currencys->id,
            'code' => $currencys->code,
            'name'  => $currencys->name,
            'rate' => $currencys->rate,
            'symbol' => $currencys->symbol,
            'created_by' => $currencys->created_by,
            'user_name' => $currencys->user->name,
            'created_at' => Carbon::parse($currencys->created_at)->format('d M Y h:m:s A'),
            'updated_at' => Carbon::parse($currencys->updated_at)->format('d M Y h:m:s A'),
        ];
    }

    public function getData($code)
    {
        return Jurnal::where('code',$code)->get();
    }

    public function download($format)
    {
        return response()->download('report_title',$format);
    }
}