<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounting\JurnalRequest;
use App\Repositories\Accounting\JurnalRepository;
use App\Response\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JurnalController extends Controller
{
    use Response;
    protected $jurnalRepository;

    public function __construct(JurnalRepository $jurnalRepository)
    {
        $this->jurnalRepository = $jurnalRepository;
    }

    public function index()
    {
        $jurnals = $this->jurnalRepository->getAll();

        if (!$jurnals->isEmpty()){
            return view('accounting.jurnal.index',compact('jurnals'));
        }

        return view('accounting.jurnal.index');
    }

    public function getJurnalNo($transaction_date)
    {
        return $this->jurnalRepository->getNextNumber($transaction_date);
    }

    public function create()
    {
        $result = '';
        $title = 'Jurnal Baru';
        $accounts = getListAccount();
        return view('accounting.jurnal.create',compact('result','title','accounts'));
    }

    public function store(JurnalRequest $request)
    {
        DB::beginTransaction();
        try {
            $result = $this->jurnalRepository->create($request);
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
        $result = $this->jurnalRepository->findById($id);
        $title = 'Edit Jurnal';
        return view('accounting.jurnal.create',compact('result','title'));
    }

    public function update(JurnalRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $result = $this->jurnalRepository->update($request, $id);
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
