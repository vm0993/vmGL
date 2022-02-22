<?php

namespace App\Http\Controllers\Advances;

use App\Http\Controllers\Controller;
use App\Http\Requests\Advance\AdvanceRequest;
use App\Core\Repositories\Advanced\RequestRepository;
use App\Response\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdvanceRequestController extends Controller
{
    use Response;
    protected $requestRepository;

    public function __construct(RequestRepository $requestRepository)
    {
        $this->requestRepository = $requestRepository;
    }

    public function index()
    {
        $results = $this->requestRepository->getAll();

        if (!$results->isEmpty()){
            return view('advance-managements.request.index',compact('results'));
        }

        return view('advance-managements.request.index',compact('results'));
    }

    public function getRequestNo($transaction_date)
    {
        return $this->requestRepository->getNextNumber($transaction_date);
    }

    public function create()
    {
        $result    = '';
        $title     = 'Req Advance Baru';
        $personels = getPersonel();
        $jobs      = getActiveJob();
        return view('advance-managements.request.create',compact('result','title','personels','jobs'));
    }

    public function store(AdvanceRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->requestRepository->create($request);
            //Looping/bulk insert to detail transaction & update balande to account balance
            
            $notification = array(
                'message'    => 'Request Advance successfull to saved!',
                'alert-type' => 'success'
            );
            DB::commit();
            return redirect()->route('advance-requests.index')->with($notification);
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
        $result    = $this->requestRepository->findById($id);
        $title     = 'Edit Request Advance';
        $personels = getPersonel();
        $jobs      = getActiveJob();
        return view('advance-managements.request.create',compact('result','title','personels','jobs'));
    }

    public function update(AdvanceRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->requestRepository->update($request, $id);
            //Looping/bulk insert to detail transaction & update balande to account balance

            DB::commit();
            return redirect()->route('advance-requests.index');
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
        $transactions = $this->requestRepository->getById($id);
        
        return $transactions;
    }

    public function submitRequestAdvance($id)
    {
        DB::beginTransaction();
        try {
            $this->requestRepository->submitRequest($id);

            DB::commit();
            $notification = array(
                'message'    => 'Request Advance successfull to saved!',
                'alert-type' => 'success'
            );

            return redirect()->route('advance-requests.index')->with($notification);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            $notification = array(
                'message'    => $th->getMessage(),
                'alert-type' => 'error',
            );
        
            return redirect()->back()->with($notification);
        }
        
    }
}
