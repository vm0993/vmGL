<?php

namespace App\Http\Controllers\Settings;

use App\Core\Repositories\Systems\RoleRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\RoleRequest;
use App\Response\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    use Response;
    protected $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        //$this->middleware('auth');
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        $results = $this->roleRepository->getAll();

        if (!$results->isEmpty()){
            return view('settings.roles.index',compact('results'));
        }

        return view('settings.roles.index',compact('results'));
    }

    public function create()
    {
        $result      = '';
        $title       = 'Role Baru';
        $permissions = getPermission();
        return view('settings.roles.create',compact('result','title','permissions'));
    }

    public function store(RoleRequest $request)
    {
        DB::beginTransaction();
        try {
            //code...
            $this->roleRepository->create($request);
            DB::commit();

            $notification = array(
                'message'    => 'Role successfull to saved!',
                'alert-type' => 'success'
            );

            return redirect()->route('roles.index')->with($notification);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();

            $notification = array(
                'message'    => $th->getMessage(),
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);

        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $result          = $this->roleRepository->findById($id);
        $title           = 'Edit Role';
        $permissions     = getPermission();
        $rolePermissions = getRolePermission($id);
        return view('settings.roles.create',compact('result','title','permissions','rolePermissions'));
    }

    public function update(RoleRequest $request, $id)
    {
        $this->roleRepository->update($request, $id);
        return redirect()->route('roles.index');
    }

    public function destroy($id)
    {
        //
    }
}
