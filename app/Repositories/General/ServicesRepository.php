<?php

namespace App\Repositories\General;

use App\Interfaces\AppInterface;
use App\Models\General\CostCharge;
use Carbon\Carbon;

class ServicesRepository implements AppInterface
{
    public function getAll()
    {
        $services = CostCharge::with(['category','WipAccount','CogsAccount','ExpenseAccount'])
                    ->orderBy('code','asc')
                    ->pagiante(10);

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
    }
    
    public function findById($id)
    {
        $service = CostCharge::find($id);
        return $this->response($service);
    }

    public function create($request)
    {
        $service = CostCharge::create($request->all());

        return $service;    
    }

    public function update($request, $id)
    {
        $service = CostCharge::find($id);
        $service->update($request->all());
        
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
            'id' => $service->id,
            'category_id' => $service->category_id,
            'category_name' => $service->category->name,
            'code' => $service->code,
            'name' => $service->name,
            'type_id' => $service->type_id,
            'wip_id' => $service->wip_id,
            'wip_account' => $service->WipAccount->account_name,
            'cogs_id' => $service->cogs_id,
            'cogs_account' => $service->CogsAccount->account_name,
            'expense_id' => $service->expense_id,
            'expense_account' => $service->ExpenseAccount->account_name,
            'created_by' => $service->created_by,
            'user_name' => $service->user->name,
            'created_at' => Carbon::parse($service->created_at)->format('d M Y h:m:s A'),
            'updated_at' => Carbon::parse($service->updated_at)->format('d M Y h:m:s A'),
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