<?php

namespace App\Http\Controllers\Generals;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\AccountRequest;
use App\Core\Repositories\General\AccountRepository;
use App\Response\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    use Response;
    protected $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function getAccountNo($account_type)
    {
        return $this->accountRepository->getNextNumber($account_type);
    }

    public function index()
    {
        $results = $this->accountRepository->getAll();
        $title = 'Data Account';
        if (!empty($results)){
            return view('accounting.account.index',compact('results','title'));
        }

        return view('accounting.account.index',compact('results','title'));
    }

    public function create()
    {
        $result = '';
        $accountTypes = getAccountTypes();
        $title = 'Akun Baru';
        return view('accounting.account.create',compact('result','accountTypes','title'));
    }

    public function getAccountByType($account_type)
    {
        $accounts = $this->accountRepository->getById($account_type);

        return response()->json($accounts);
    }

    public function store(AccountRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->accountRepository->create($request);
            DB::commit();

            return redirect()->route('accounts.index');
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
        $result = $this->accountRepository->findById($id);
        $title = 'Edit Account';
        return view('accounting.account.create',compact('result','title'));
    }

    public function update(AccountRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->accountRepository->update($request, $id);
            DB::commit();

            return redirect()->route('accounts.index');
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
