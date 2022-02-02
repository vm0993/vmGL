<?php

namespace App\Repositories\General;

use App\Interfaces\AppInterface;
use App\Models\Accounting\Accounts\Account;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AccountRepository implements AppInterface
{
    public function getAll()
    {
        $accounts = Account::orderBy('account_no','asc')
                    ->paginate(10);

                    $accounts->getCollection()->transform(function ($items) {
                        return $this->response($items);
                    });

        return $accounts;
    }

    public function getNextNumber($account_type)
    {
        return Account::getAccountNo($account_type);
    }

    public function getById($account_type)
    {
        $accounts = Account::select('id','account_no','account_name')
                    ->where([
                        ['account_type',$account_type],
                        ['status','ACTIVE'],
                    ])
                    ->orderBy('id','asc')
                    ->get();

        return $accounts;
    }

    public function findById($id)
    {
        $account = Account::find($id);
        return $this->response($account);
    }

    public function create($request)
    {
        $account = Account::create($request->all());
        return $account;    
    }

    public function update($request, $id)
    {
        $account = Account::find($id);
        $account->update($request->all());
        
        return $account; 
    }

    public function delete($id)
    {
        $account = Account::find($id);
        $account->delete();

        return $account;
    }

    public function response($account)
    {
        return [
            'id' => $account->id,
            'account_no' => $account->account_no,
            'account_name' => $account->account_name,
            'account_type' => $account->account_type,
            'can_jurnal' => $account->can_jurnal,
            'parent_account' => $account->parent_account_id,
            'sub_account' => $account->parent_account_id == 0 ? '' : $account->subAccount->account_no,
            'created_by' => $account->created_by,
            'balance' => number_format($account->account_balance),
            'user_name' => $account->user->name,
            'status' => $account->status,
            'created_at' => Carbon::parse($account->created_at)->format('d M Y h:m:s A'),
            'updated_at' => Carbon::parse($account->updated_at)->format('d M Y h:m:s A'),
        ];
    }

    public function getData($account_no)
    {
        return Account::where('account_no',$account_no)->get();
    }

    public function download($format)
    {
        return response()->download('report_title',$format);
    }
}