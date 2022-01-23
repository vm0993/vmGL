<?php

namespace App\Repositories\General;

use App\Interfaces\AppInterface;
use App\Models\General\Category;
use Carbon\Carbon;

class CategoryRepository implements AppInterface
{
    public function getAll()
    {
        $categorys = Category::orderBy('name','asc')
                    ->paginate(10);

        $categorys->getCollection()->transform(function ($items) {
            return $this->response($items);
        });
                    
        return $categorys;
    }

    public function getNextNumber($value)
    {
    }

    public function getById($value)
    {
    }

    public function findById($id)
    {
        $category = Category::find($id);
        return $this->response($category);
    }

    public function create($request)
    {
        $category = Category::create($request->all());

        return $category;    
    }

    public function update($request, $id)
    {
        $data = [
            'name' => $request->name,
        ];
        $category = Category::find($id);
        $category->update($data);
        
        return $category; 
    }

    public function delete($id)
    {
        $category = Category::find($id);
        $category->delete();

        return $category;
    }

    public function response($category)
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'created_by' => $category->created_by,
            'user_name' => $category->user->name,
            'status' => $category->status,
            'created_at' => Carbon::parse($category->created_at)->format('d M Y h:m:s A'),
            'updated_at' => Carbon::parse($category->updated_at)->format('d M Y h:m:s A'),
        ];
    }

    public function getData($code)
    {
        return Category::where('code',$code)->get();
    }

    public function download($format)
    {
        return response()->download('report_title',$format);
    }
}