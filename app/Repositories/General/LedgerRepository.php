<?php

namespace App\Repositories\General;

use App\Interfaces\AppInterface;
use App\Models\General\Ledger;
use Carbon\Carbon;

class LedgerRepository implements AppInterface
{
    public function getAll()
    {
        $ledgers = Ledger::orderBy('name')
                    ->paginate(10);

        $ledgers->getCollection()->transform(function ($items) {
            return $this->response($items);
        });      

        return $ledgers;
    }

    public function getNextNumber($value)
    {
    }

    public function getById($value)
    {
    }
    
    public function findById($id)
    {
        $ledger = Ledger::find($id);
        return $this->response($ledger);
    }

    public function create($request)
    {
        $ledger = Ledger::create($request->all());

        return $ledger;    
    }

    public function update($request, $id)
    {
        $ledger = Ledger::find($id);
        $ledger->update($request->all());
        
        return $ledger; 
    }

    public function delete($id)
    {
        $ledger = Ledger::find($id);
        $ledger->delete();

        return $ledger;
    }

    public function response($ledger)
    {
        return [
            'id' => $ledger->id,
            'type' => $ledger->type,
            'code' => $ledger->code,
            'name'  => $ledger->name,
            'address' => $ledger->address,
            'other_address' => $ledger->other_address,
            'phone_no' => $ledger->phone_no,
            'fax_no' => $ledger->fax_no,
            'tax_reg_no' => $ledger->tax_reg_no,
            'bank_account' => $ledger->bank_account,
            'begining_balance' => $ledger->begining_balance,
            'created_by' => $ledger->created_by,
            'status' => $ledger->status,
            'user_name' => $ledger->user->name,
            'created_at' => Carbon::parse($ledger->created_at)->format('d M Y h:m:s A'),
            'updated_at' => Carbon::parse($ledger->updated_at)->format('d M Y h:m:s A'),
        ];
    }

    public function getData($code)
    {
        return Ledger::where('code',$code)->get();
    }

    public function download($format)
    {
        return response()->download('report_title',$format);
    }
}