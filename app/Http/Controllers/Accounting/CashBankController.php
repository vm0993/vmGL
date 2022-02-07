<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounting\CashBankRequest;
use App\Repositories\Accounting\CashBankRepository;
use App\Response\Response;
use Illuminate\Http\Request;

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
        $cashBanks = $this->cashBankRepository->getAll();

        if (!$cashBanks->isEmpty()){
            return view('accounting.cash-bank.index',compact('cashBanks'));
        }

        return view('accounting.cash-bank.index');
    }

    public function create()
    {
        $result = '';
        $title = 'Cash Bank Baru';
        return view('accounting.cash-bank.create',compact('result','title'));
    }

    public function store(CashBankRequest $request)
    {
        $this->cashBankRepository->create($request);
        return redirect()->route('categories.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $result = $this->cashBankRepository->findById($id);
        $title = 'Edit Cash Bank';
        return view('accounting.cash-bank.create',compact('result','title'));
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
}
