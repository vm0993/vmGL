<?php

namespace App\Http\Livewire\GeneralLedgers;

use App\Models\GeneralLedgers\Currency as GeneralLedgersCurrency;
use Livewire\Component;

class Currency extends Component
{
    public $currency_id, $code, $name, $symbol, $rate;
    public $isModalOpen = 0;

    public function render()
    {
        return view('livewire.general-ledgers.currency', [
            'currencies' => GeneralLedgersCurrency::orderBy('id', 'desc')->paginate(10)
        ]);
        //return view('livewire.general-ledgers.currency');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
        // Clean errors if were visible before
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    private function resetInputFields(){
        $this->code = '';
        $this->name = '';
        $this->symbol = '';
        $this->rate = 0;
    }

    public function store()
    {
        $this->validate([
            'code' => 'required|unique:currencies,code,'.$this->code,
            'name' => 'required',
            'rate' => 'required',
        ]);
        $data = array(
            'code'   => $this->code,
            'name'   => $this->name,
            'rate'   => $this->rate,
            'symbol' => $this->symbol,
        );
        GeneralLedgersCurrency::updateOrCreate(['id' => $this->currency_id],$data);
        session()->flash('message', $this->code ? 'Currency updated successfully.' : 'Currency created successfully.');
        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $currency = GeneralLedgersCurrency::findOrFail($id);
        $this->currency_id = $id;
        $this->code = $currency->code;
        $this->name = $currency->name;
        $this->rate = $currency->rate;
        $this->symbol = $currency->symbol;
        $this->openModal();
    }

    public function delete($id)
    {
        $this->currency_id = $id;
        GeneralLedgersCurrency::find($id)->delete();
        session()->flash('message', 'Currency deleted successfully.');
    }
}
