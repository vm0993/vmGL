<?php

namespace App\Http\Controllers\Settings;

use App\Core\Repositories\Systems\UserRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\UserRequest;
use App\Response\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    use Response;
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        //$this->middleware('auth');
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $results = $this->userRepository->getAll();

        if (!$results->isEmpty()){
            return view('settings.users.index',compact('results'));
        }

        return view('settings.users.index',compact('results'));
    }

    public function create()
    {
        $result      = '';
        $title       = 'User Baru';
        $permissions = getPermission();
        return view('settings.users.create',compact('result','title','permissions'));
    }

    public function store(UserRequest $request)
    {
        DB::beginTransaction();
        try {
            //code...
            $this->userRepository->create($request);
            DB::commit();

            $notification = array(
                'message'    => 'User successfull to saved!',
                'alert-type' => 'success'
            );

            return redirect()->route('user.index')->with($notification);
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
        $result          = $this->userRepository->findById($id);
        $title           = 'Edit User';
        $permissions     = getPermission();
        $rolePermissions = getRolePermission($id);
        return view('settings.users.create',compact('result','title','permissions','rolePermissions'));
    }

    public function update(UserRequest $request, $id)
    {
        $this->userRepository->update($request, $id);
        return redirect()->route('user.index');
    }

    public function destroy($id)
    {
        //
    }
}
