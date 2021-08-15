<?php

namespace App\Http\Livewire\General;

use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\Accounting\Bank;
use App\Models\General\Ledger;
use Livewire\Component;

class Ledgers extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;

    public $code, $name, $address, $other_address, $phone_no, $fax_no, $tax_reg_no,$bank_id,$personel_name, $bank_account, $beneficiary_name,$balance, $ledger_id;
    
    public $showDeleteModal = false;
    public $showEditModal = false;
    public $showFilters = false;
    public $confirmingDeletion = false;
    public Ledger $editing;
    protected $queryString = ['sorts'];
    public $filters = [
        'search' => '',
        'code' => '',
        'name' => '',
    ];

    protected $listeners = ['refreshTransactions' => '$refresh'];

    public function rules() { 
        return [ 
            'editing.code' => 'required|min:3',
            'editing.name' => 'required',
            'editing.address' => 'nullable',
            'editing.address_other' => 'nullable',
            'editing.phone_no' => 'nullable',
            'editing.fax_no' => 'nullable',
            'editing.personel_name' => 'nullable',
            'editing.tax_reg_no' => 'nullable',
            'editing.bank_id' => 'nullable',
            'editing.bank_account' => 'nullable',
            'editing.beneficiary_name' => 'nullable',
        ]; 
    }

    public function mount() { $this->editing = $this->makeBlankTransaction(); }
    public function updatedFilters() { $this->resetPage(); }

    public function toggleShowFilters()
    {
        $this->useCachedRows();

        $this->showFilters = ! $this->showFilters;
    }

    public function resetFilters() { $this->reset('filters'); }

    public function makeBlankTransaction()
    {
        return Ledger::make(['bank_id' => 0, 'status' => 0]);
    }

    public function getRowsQueryProperty()
    {
        $query = Ledger::query()
            ->when($this->filters['code'], fn($query, $code) => $query->where('code', 'like', '%'.$code.'%'))
            ->when($this->filters['name'], fn($query, $name) => $query->where('name', 'like', '%'.$name.'%'))
            ->when($this->filters['search'], fn($query, $search) => $query->where('name', 'like', '%'.$search.'%'));

        return $this->applySorting($query);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.general.ledgers',[
            'ledgers' => $this->rows, 
            'banks' => Bank::select('id','code','name')->where('status',0)->get()
        ]);
    }

    public function create()
    {
        $this->useCachedRows();

        if ($this->editing->getKey()) $this->editing = $this->makeBlankTransaction();
        $this->ledger_id = '';
        $this->showEditModal = true;
    }

    public function save()
    {
        $this->validate();
        try {
            $this->editing->save();
            $this->showEditModal = false;
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Ledger Created Successfully!!"
            ]);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"Something goes wrong while creating ledger!!"
            ]);
        }
    }

    public function edit(Ledger $ledger)
    {
        $this->useCachedRows();

        if ($this->editing->isNot($ledger)) $this->editing = $ledger;
        $this->ledger_id = $ledger->id;
        $this->showEditModal = true;
    }

    public function closeModal()
    {
        $this->showEditModal = false;
    }

    public function delete(Ledger $ledger)
    {
        $ledger->delete();
        $this->confirmingDeletion = false;
        session()->flash('message', 'Ledger Deleted Successfully');
    }

    public function confirmingDeletion( $id) 
    {
        $this->confirmingDeletion = $id;
    }
}
