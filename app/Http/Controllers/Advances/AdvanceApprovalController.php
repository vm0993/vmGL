<?php

namespace App\Http\Controllers\Advances;

use App\Http\Controllers\Controller;
use App\Http\Requests\Advance\ApproveRequest;
use App\Core\Repositories\Advanced\ApprovalRepository;
use App\Response\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdvanceApprovalController extends Controller
{
    use Response;
    protected $approvalRepository;

    public function __construct(ApprovalRepository $approvalRepository)
    {
        $this->approvalRepository = $approvalRepository;
    }

    public function index()
    {
        $results = $this->approvalRepository->getAll();

        if (!$results->isEmpty()){
            return view('advance-managements.approve.index',compact('results'));
        }

        return view('advance-managements.approve.index',compact('results'));
    }

    public function getRequestNo($transaction_date)
    {
        return $this->approvalRepository->getNextNumber($transaction_date);
    }

    public function create()
    {
        
    }

    public function store(ApproveRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->approvalRepository->create($request);
            //Looping/bulk insert to detail transaction & update balande to account balance
            
            DB::commit();
            return redirect()->route('advance-approvals.index');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
        }
    }

    public function show($id)
    {
        //
    }

    public function approveRequest($id)
    {
        $result    = $this->approvalRepository->findById($id);
        $title     = 'Approval Request';
        $personels = getPersonel();
        $jobs      = getActiveJob();
        return view('advance-managements.approve.create',compact('result','title','personels','jobs'));
    }

    public function update(ApproveRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->approvalRepository->update($request, $id);
            //Looping/bulk insert to detail transaction & update balande to account balance

            DB::commit();
            return redirect()->route('advance-approvals.index');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
        }
    }

    public function destroy($id)
    {
        //
    }

    public function getTransaction($id)
    {
        $transactions = $this->approvalRepository->getById($id);
        
        return $transactions;
    }
}
