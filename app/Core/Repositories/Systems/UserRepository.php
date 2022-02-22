<?php

namespace App\Core\Repositories\Systems;

use App\Core\Interfaces\Systems\UserInterface;
use App\Models\User;
use Carbon\Carbon;

class UserRepository implements UserInterface
{
    public function getAll()
    {
        $users = User::orderBy('name','asc')
                    ->paginate(10);

        $users->getCollection()->transform(function ($items) {
            return $this->response($items);
        });
                    
        return $users;
    }

    public function findById($id)
    {
        $user = User::find($id);
        return $this->response($user);
    }

    public function create($request)
    {
        $user = User::create($request->all());
        if($request->roles != ''){
            $user->assignRole($request->roles);
        }
        return $user;    
    }

    public function update($request, $id)
    {
        $data = [
            'name' => $request->name,
        ];
        $user = User::find($id);
        $user->update($data);

        $user->assignRole($request->roles);
        
        return $user; 
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();

        return $user;
    }

    public function response($user)
    {
        return [
            'id'         => $user->id,
            'name'       => $user->name,
            'email'      => $user->email,
            'created_at' => Carbon::parse($user->created_at)->format('d M Y h:m:s A'),
            'updated_at' => Carbon::parse($user->updated_at)->format('d M Y h:m:s A'),
        ];
    }

}