<?php

namespace App\Core\Repositories\General;

use App\Core\Interfaces\General\DepartmentInterface;
use App\Models\General\Department;
use Carbon\Carbon;

class DepartmentRepository implements DepartmentInterface
{
    public function getAll()
    {
        $departments = Department::orderBy('id','desc')
                        ->paginate(10);

        $departments->getCollection()->transform(function ($items) {
            return $this->response($items);
        });

        return $departments;
    }
    
    public function findById($id)
    {
        $department = Department::find($id);
        return $this->response($department);
    }

    public function create($request)
    {
        $department = Department::create($request->all());

        return $department;    
    }

    public function update($request, $id)
    {
        $department = Department::find($id);
        $department->update($request->all());
        
        return $department; 
    }

    public function delete($id)
    {
        $department = Department::find($id);
        $department->delete();

        return $department;
    }

    public function response($department)
    {
        return [
            'id'         => $department->id,
            'name'       => $department->name,
            'created_by' => $department->created_by,
            'user_name'  => $department->user->name,
            'status'     => $department->status,
            'created_at' => Carbon::parse($department->created_at)->format('d M Y h:m:s A'),
            'updated_at' => Carbon::parse($department->updated_at)->format('d M Y h:m:s A'),
        ];
    }
}