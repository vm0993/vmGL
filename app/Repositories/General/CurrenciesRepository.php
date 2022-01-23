<?php

namespace App\Repositories\General;

use App\Interfaces\AppInterface;
use App\Models\Accounting\Currencys\Currency;
use Carbon\Carbon;

class CurrenciesRepository implements AppInterface
{
    public function getAll()
    {
        $currencys = Currency::orderBy('name')
                    ->paginate(10);

        $currencys->getCollection()->transform(function ($items) {
            return $this->response($items);
        });

        return $currencys;
    }

    public function getNextNumber($value)
    {
    }

    public function getById($value)
    {
    }
    
    public function findById($id)
    {
        $currency = Currency::find($id);
        return $this->response($currency);
    }

    public function create($request)
    {
        $currency = Currency::create($request->all());

        return $currency;    
    }

    public function update($request, $id)
    {
        $currency = Currency::find($id);
        $currency->update($request->all());
        
        return $currency; 
    }

    public function delete($id)
    {
        $currency = Currency::find($id);
        $currency->delete();

        return $currency;
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
        return Currency::where('code',$code)->get();
    }

    public function download($format)
    {
        return response()->download('report_title',$format);
    }
}