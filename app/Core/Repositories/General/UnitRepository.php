<?php

namespace App\Core\Repositories\General;

use App\Core\Interfaces\General\UnitInterface;
use App\Models\General\Unit;
use Carbon\Carbon;

class UnitRepository implements UnitInterface
{
    public function getAll()
    {
        $categorys = Unit::orderBy('id','desc')
                    ->paginate(10);

        $categorys->getCollection()->transform(function ($items) {
            return $this->response($items);
        });
                    
        return $categorys;
    }

    public function findById($id)
    {
        $category = Unit::find($id);
        return $this->response($category);
    }

    public function create($request)
    {
        $category = Unit::create($request->all());

        return $category;    
    }

    public function update($request, $id)
    {
        $data = [
            'name' => $request->name,
        ];
        $category = Unit::find($id);
        $category->update($data);
        
        return $category; 
    }

    public function delete($id)
    {
        $category = Unit::find($id);
        $category->delete();

        return $category;
    }

    public function response($category)
    {
        return [
            'id'         => $category->id,
            'name'       => $category->name,
            'created_by' => $category->created_by,
            'user_name'  => $category->user->name,
            'status'     => $category->status,
            'created_at' => Carbon::parse($category->created_at)->format('d M Y h:m:s A'),
            'updated_at' => Carbon::parse($category->updated_at)->format('d M Y h:m:s A'),
        ];
    }
}