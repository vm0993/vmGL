<?php

namespace App\Http\Livewire\GeneralLedgers;

use Livewire\Component;
use Livewire\WithPagination;

class Jurnal extends Component
{
    use WithPagination;

    public $search = '';
    public $jurnal_id,$code, $transaction_date, $description ;

    public function render()
    {
        return view('livewire.general-ledgers.jurnal');
    }
}
