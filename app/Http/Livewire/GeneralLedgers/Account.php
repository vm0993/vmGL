<?php

namespace App\Http\Livewire\GeneralLedgers;

use Livewire\Component;
use Livewire\WithPagination;

class Account extends Component
{
    use WithPagination;

    public $search = '';
    public $account_no, $account_name,$account_type, $group_account,$can_jurnal;

    protected $rules = [
        'account_no' => 'required|min:3',
        'account_name' => 'required|min:3',
        'account_type' => 'required',
    ];

    protected $messages = [
        'account_no.required' => 'Account No cannot be empty!',
        'account_name.required' => 'Account Name cannot be empty!',
        'account_type.required' => 'Account Type cannot be empty!',
    ];

    public function render()
    {
        return view('livewire.general-ledgers.account');
    }

    public function paginationView()
    {
        return 'pagination';
    }
}
