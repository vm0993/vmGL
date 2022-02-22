<?php

namespace App\Core\Repositories\General;

use App\Core\Interfaces\General\ServiceInterface;
use App\Models\General\CostCharge;
use Carbon\Carbon;

class ServicesRepository implements ServiceInterface
{
    public function getAll()
    {
        $services = CostCharge::with(['category','WipAccount','CogsAccount','ExpenseAccount'])
                    ->orderBy('code','asc')
                    ->paginate(10);

        $services->getCollection()->transform(function ($items) {
            return $this->response($items);
        });

        return $services;
    }

    public function getNextNumber($value)
    {
    }
    
    public function getById($value)
    {
        $charges = CostCharge::getServicesByType($value);

        return $charges;
    }
    
    public function findById($id)
    {
        $service = CostCharge::find($id);
        return $this->response($service);
    }

    public function create($request)
    {
        $data = [
            'categori_id' => $request->categori_id,
            'type_id'     => $request->type_id,
            'code'        => $request->code,
            'name'        => $request->name,
            'wip_id'      => $request->wip_id == null ? 0 : $request->wip_id,
            'cogs_id'     => $request->cogs_id == null ? 0 : $request->cogs_id,
            'expense_id'  => $request->expense_id == null ? 0 : $request->expense_id,
        ];

        //dd($data);
        $service = CostCharge::create($data);

        return $service;    
    }

    public function update($request, $id)
    {
        $data = [
            'categori_id' => $request->categori_id,
            'type_id'     => $request->type_id,
            'code'        => $request->code,
            'name'        => $request->name,
            'wip_id'      => $request->wip_id == null ? 0 : $request->wip_id,
            'cogs_id'     => $request->cogs_id == null ? 0 : $request->cogs_id,
            'expense_id'  => $request->expense_id == null ? 0 : $request->expense_id,
        ];

        $service = CostCharge::find($id);
        $service->update($data);
        
        return $service; 
    }

    public function delete($id)
    {
        $service = CostCharge::find($id);
        $service->delete();

        return $service;
    }

    public function response($service)
    {
        return [
            'id'              => $service->id,
            'categori_id'     => $service->categori_id,
            'category_name'   => $service->category->name,
            'code'            => $service->code,
            'name'            => $service->name,
            'type_id'         => $service->type_id,
            'wip_id'          => $service->wip_id,
            'wip_account'     => $service->wip_id == 0 ? "" : $service->WipAccount->account_name,
            'cogs_id'         => $service->cogs_id,
            'cogs_account'    => $service->cogs_id == 0 ? "" :  $service->CogsAccount->account_name,
            'expense_id'      => $service->expense_id,
            'expense_account' => $service->expense_id == 0 ? "" :  $service->ExpenseAccount->account_name,
            'created_by'      => $service->created_by,
            'user_name'       => $service->user->name,
            'created_at'      => Carbon::parse($service->created_at)->format('d M Y h:m:s A'),
            'updated_at'      => Carbon::parse($service->updated_at)->format('d M Y h:m:s A'),
        ];
    }

    public function getData($code)
    {
        return CostCharge::where('code',$code)->get();
    }

    public function download($format)
    {
        return response()->download('report_title',$format);
    }
}