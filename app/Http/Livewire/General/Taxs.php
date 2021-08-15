<?php

namespace App\Http\Livewire\General;

use App\Exports\General\TaxExport;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\Accounting\Account;
use App\Models\General\Tax;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class Taxs extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;

    public $code, $name, $purchase_id, $sales_id, $rate, $tax_id;
    
    public $showDeleteModal = false;
    public $showEditModal = false;
    public $showFilters = false;
    public $confirmingDeletion = false;
    public Tax $editing;
    protected $queryString = ['sorts'];
    public $filters = [
        'search' => '',
        'code' => '',
        'name' => '',
        'sales_id' => '',
        'purchase_id' => '',
    ];

    protected $listeners = ['refreshTransactions' => '$refresh'];

    public function rules() { 
        return [
            'editing.code' => 'required|min:2',
            'editing.name' => 'required',
            'editing.sales_id' => 'required',
            'editing.purchase_id' => 'required',
            'editing.rate' => 'required',
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
        return Tax::make(['sales_id' => 0,'purchase_id' => 0, 'status' => 0]);
    }

    public function getRowsQueryProperty()
    {
        $results = Tax::select(DB::raw('taxes.id,taxes.code,taxes.name,taxes.rate,taxes.purchase_id,taxes.sales_id,
                    (select concat(account_no," - ",account_name) as accName from accounts where id=taxes.purchase_id) as purchaseAccount,
                    (select concat(account_no," - ",account_name) as accName from accounts where id=taxes.sales_id) as salesAccount'))
                    ->where('taxes.status',0);
                
        $query = $results
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
        return view('livewire.general.taxs',[
            'taxes' => $this->rows, 
            'accounts' => Account::select('id','account_no','account_name')->where('status',0)->get()
        ]);
    }

    public function create()
    {
        $this->useCachedRows();

        if($this->editing->getKey()) $this->editing = $this->makeBlankTransaction();
        $this->tax_id = '';
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
                'message'=>"Tax Created Successfully!!"
            ]);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"Something goes wrong while creating tax!!"
            ]);
        }
    }

    public function edit(Tax $tax)
    {
        $this->useCachedRows();

        if ($this->editing->isNot($tax)) $this->editing = $tax;
        $this->tax_id = $tax->id;
        $this->showEditModal = true;
    }

    public function closeModal()
    {
        $this->showEditModal = false;
    }

    public function delete(Tax $tax)
    {
        $tax->delete();
        $this->confirmingDeletion = false;
        session()->flash('message', 'Tax Deleted Successfully');
    }

    public function confirmingDeletion( $id) 
    {
        $this->confirmingDeletion = $id;
    }

    public function downloadExcel()
    {
        return Excel::download(new TaxExport,'Taxes.xlsx');
    }

    public function downloadPDF()
    {
        $results = Tax::all();
        $title = 'Daftar Kode Pajak';
        $params = [
            'settings' => setSetting(),
            'title'  => $title,
            'results' => $results,
        ];
        $pdf = PDF::loadView('reports.generals.taxes.pdf', $params)->output();
        return response()->streamDownload(
            fn () => print($pdf),
            $title.'.pdf'
        );
    }
}
