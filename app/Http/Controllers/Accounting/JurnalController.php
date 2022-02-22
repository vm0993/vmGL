<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounting\JurnalRequest;
use App\Core\Repositories\Accounting\JurnalRepository;
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
        $results = $this->jurnalRepository->getAll();

        if (!$results->isEmpty()){
            return view('accounting.jurnal.index',compact('results'));
        }

        return view('accounting.jurnal.index',compact('results'));
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
            $this->jurnalRepository->create($request);
            
            $notification = array(
                'message'    => 'Jurnal successfull to saved!',
                'alert-type' => 'success'
            );
            DB::commit();
            return redirect()->route('jurnals.index')->with($notification);
        } catch (\Throwable $th) {
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
        $result = $this->jurnalRepository->findById($id);
        $title = 'Edit Jurnal';
        $accounts = getListAccount();
        return view('accounting.jurnal.create',compact('result','title','accounts'));
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

    public function getTransaction($id)
    {
        $transactions = $this->jurnalRepository->getById($id);

        return $transactions;
    }
}
