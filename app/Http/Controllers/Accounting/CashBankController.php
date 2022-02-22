<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounting\CashBankRequest;
use App\Core\Repositories\Accounting\CashBankRepository;
use App\Response\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashBankController extends Controller
{
    use Response;
    protected $cashBankRepository;

    public function __construct(CashBankRepository $cashBankRepository)
    {
        $this->cashBankRepository = $cashBankRepository;
    }

    public function index()
    {
        $results = $this->cashBankRepository->getAll();

        if (!$results->isEmpty()){
            return view('accounting.cash-bank.index',compact('results'));
        }

        return view('accounting.cash-bank.index',compact('results'));
    }

    public function create()
    {
        $result = '';
        $title = 'Cash Bank Baru';
        $accounts = getListAccount();
        $banks = getCashBankAccount();
        return view('accounting.cash-bank.create',compact('result','title','accounts','banks'));
    }

    public function store(CashBankRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->cashBankRepository->create($request);
            
            $notification = array(
                'message'    => 'Cash/Bank successfull to saved!',
                'alert-type' => 'success'
            );
            DB::commit();
            return redirect()->route('cash-banks.index')->with($notification);
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
        $result = $this->cashBankRepository->findById($id);
        $title = 'Edit Cash Bank';
        $accounts = getListAccount();
        $banks = getCashBankAccount();
        return view('accounting.cash-bank.create',compact('result','title','accounts','banks'));
    }

    public function update(CashBankRequest $request, $id)
    {
        $this->cashBankRepository->update($request, $id);
        return redirect()->route('categories.index');
    }

    public function destroy($id)
    {
        //
    }

    public function getCashBankNo($transaction_date, $tipe)
    {
        return $this->cashBankRepository->getNextNumber($transaction_date, $tipe);
    }

    public function getTransaction($id)
    {
        $transactions = $this->cashBankRepository->getById($id);

        return $transactions;
    }
}
