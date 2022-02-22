<?php

namespace App\Core\Repositories\General;

use App\Core\Interfaces\General\TaxInterface;
use App\Models\General\Tax;
use Carbon\Carbon;

class TaxRepository implements TaxInterface
{
    public function getAll()
    {
        $taxes = Tax::orderBy('id','desc')
                    ->paginate(10);

        $taxes->getCollection()->transform(function ($items) {
            return $this->response($items);
        });
                    
        return $taxes;
    }

    public function findById($id)
    {
        $tax = Tax::find($id);
        return $this->response($tax);
    }

    public function create($request)
    {
        $data = [
            'code'                => $request->code,
            'name'                => $request->name,
            'rate'                => $request->rate,
            'purchase_account_id' => $request->purchase_account_id,
            'sales_account_id'    => $request->sales_account_id,
        ];

        $tax = Tax::create($data);

        return $tax;    
    }

    public function update($request, $id)
    {
        $data = [
            'code'                => $request->code,
            'name'                => $request->name,
            'rate'                => $request->rate,
            'purchase_account_id' => $request->purchase_account_id,
            'sales_account_id'    => $request->sales_account_id,
        ];
        $tax = Tax::find($id);
        $tax->update($data);
        
        return $tax; 
    }

    public function delete($id)
    {
        $tax = Tax::find($id);
        $tax->delete();

        return $tax;
    }

    public function response($tax)
    {
        return [
            'id'                  => $tax->id,
            'code'                => $tax->code,
            'name'                => $tax->name,
            'rate'                => $tax->rate,
            'purchase_account_id' => $tax->purchase_account_id,
            'sales_account_id'    => $tax->sales_account_id,
            'purchase_account'    => $tax->purchaseAccount->account_no . ' - '. $tax->purchaseAccount->account_name,
            'sales_account'       => $tax->salesAccount->account_no . ' - '. $tax->salesAccount->account_name,
            'created_by'          => $tax->created_by,
            'user_name'           => $tax->user->name,
            'status'              => $tax->status,
            'created_at'          => Carbon::parse($tax->created_at)->format('d M Y h:m:s A'),
            'updated_at'          => Carbon::parse($tax->updated_at)->format('d M Y h:m:s A'),
        ];
    }
}