<?php

namespace App\Http\Controllers\Settings;

use App\Core\Repositories\Advanced\ApprovalRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\ApprovalRequest;
use App\Response\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApprovalController extends Controller
{
    use Response;
    protected $approvalRepository;

    public function __construct(ApprovalRepository $approvalRepository)
    {
        //$this->middleware('auth');
        $this->approvalRepository = $approvalRepository;
    }

    public function index()
    {
        $results = $this->approvalRepository->getAll();

        if (!$results->isEmpty()){
            return view('settings.approvals.index',compact('results'));
        }

        return view('settings.approvals.index',compact('results'));
    }

    public function create()
    {
        $result      = '';
        $title       = 'Approval Baru';
        $permissions = getPermission();
        return view('settings.approvals.create',compact('result','title','permissions'));
    }

    public function store(ApprovalRequest $request)
    {
        DB::beginTransaction();
        try {
            //code...
            $this->approvalRepository->create($request);
            DB::commit();

            $notification = array(
                'message'    => 'Approval successfull to saved!',
                'alert-type' => 'success'
            );

            return redirect()->route('approval.index')->with($notification);
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
        $result          = $this->approvalRepository->findById($id);
        $title           = 'Edit Role';
        $permissions     = getPermission();
        $rolePermissions = getRolePermission($id);
        return view('settings.approvals.create',compact('result','title','permissions','rolePermissions'));
    }

    public function update(ApprovalRequest $request, $id)
    {
        $this->approvalRepository->update($request, $id);
        return redirect()->route('approval.index');
    }

    public function destroy($id)
    {
        //
    }
}
