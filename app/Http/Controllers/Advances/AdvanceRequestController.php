<?php

namespace App\Http\Controllers\Advances;

use App\Http\Controllers\Controller;
use App\Http\Requests\Advance\AdvanceRequest;
use App\Repositories\Advanced\RequestRepository;
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
        $jurnals = $this->requestRepository->getAll();

        if (!$jurnals->isEmpty()){
            return view('advance-managements.request.index',compact('jurnals'));
        }

        return view('advance-managements.request.index');
    }

    public function getJurnalNo($transaction_date)
    {
        return $this->requestRepository->getNextNumber($transaction_date);
    }

    public function create()
    {
        $result = '';
        $title = 'Jurnal Baru';
        return view('accounting.jurnal.create',compact('result','title'));
    }

    public function store(AdvanceRequest $request)
    {
        DB::beginTransaction();
        try {
            $result = $this->requestRepository->create($request);
            //Looping/bulk insert to detail transaction & update balande to account balance
            
            DB::commit();
            return redirect()->route('categories.index');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $result = $this->requestRepository->findById($id);
        $title = 'Edit Jurnal';
        return view('accounting.jurnal.create',compact('result','title'));
    }

    public function update(AdvanceRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $result = $this->requestRepository->update($request, $id);
            //Looping/bulk insert to detail transaction & update balande to account balance

            DB::commit();
            return redirect()->route('categories.index');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
        }
    }

    public function destroy($id)
    {
        //
    }
}
