<?php

namespace App\Core\Repositories\Systems;

use App\Core\Interfaces\Systems\RoleInterface;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class RoleRepository implements RoleInterface
{
    public function getAll()
    {
        $roles = Role::orderBy('id','asc')
                    ->paginate(10);

        $roles->getCollection()->transform(function ($items) {
            return $this->response($items);
        });
                    
        return $roles;
    }

    public function findById($id)
    {
        $role = Role::find($id);
        return $this->response($role);
    }

    public function create($request)
    {
        $data = [
            'name' => $request->name,
        ];
        $role = Role::create($data);
        
        $role->syncPermissions($request->input('permission'));

        return $role;    
    }

    public function update($request, $id)
    {
        $data = [
            'name' => $request->name,
        ];
        $role = Role::find($id);
        $role->update($data);

        $role->syncPermissions($request->input('permission'));
        
        return $role; 
    }

    public function delete($id)
    {
        $role = Role::find($id);
        $role->delete();

        return $role;
    }

    public function response($role)
    {
        return [
            'id'         => $role->id,
            'name'       => Str::upper($role->name),
            'created_at' => Carbon::parse($role->created_at)->format('d M Y h:m:s A'),
            'updated_at' => Carbon::parse($role->updated_at)->format('d M Y h:m:s A'),
        ];
    }

    public function getData($code)
    {
        return Role::where('code',$code)->get();
    }

    public function download($format)
    {
        return response()->download('report_title',$format);
    }
}