<?php

namespace App\Http\Livewire\General;

use App\Exports\General\ChargeCodeExport;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\General\Category;
use App\Models\General\Service;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class Services extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;

    public $category_id, $code, $name, $type_id, $advances, $advance_account_id, $wip_id, $wips, $cogs_id, $cogs, $expense_id, $expenses, $service_id;
    
    public $updateMode = 0;
    public $selectCategory = false;
    public $showDeleteModal = false;
    public $confirmingDeletion = false;
    public $showEditModal = false;
    public $showFilters = false;
    public Service $editing;
    protected $queryString = ['sorts'];
    public $filters = [
        'search' => '',
        'code' => '',
        'name' => '',
    ];

    protected $listeners = ['refreshTransactions' => '$refresh'];

    public function rules() { 
        return [
            'editing.category_id' => 'required',
            'editing.code' => 'required|min:3',
            'editing.name' => 'required',
            'editing.type_id' => 'required',
            'editing.wip_id' => 'nullable',
            'editing.cogs_id' => 'nullable',
            'editing.expense_id' => 'nullable',
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

    public function confirmDeletio($id)
    {
        $this->confirmingDeletion = $id;
    }

    public function deleteSelected()
    {
        $deleteCount = $this->selectedRowsQuery->count();

        $this->selectedRowsQuery->delete();

        $this->showDeleteModal = false;
        $this->confirmingDeletion = false;
        $this->notify('You\'ve deleted '.$deleteCount.' transactions');
    }

    public function makeBlankTransaction()
    {
        return Service::make(
            [
                'category_id' => 0,
                'type_id' => 0,
                'wip_id' => 0,
                'cogs_id' => 0,
                'expense_id' => 0,
            ]);
    }

    public function getRowsQueryProperty()
    {
        $results = Service::select(DB::raw('services.id,services.code,services.name,services.type_id,categories.name as catname,categories.code as kode,services.advance_account_id,services.wip_id,services.cogs_id,services.expense_id'))
                    ->join('categories','categories.id','=','services.category_id');
        $query = $results
            ->when($this->filters['code'], fn($query, $code) => $query->where('services.code', 'like', '%'.$code.'%'))
            ->when($this->filters['name'], fn($query, $name) => $query->where('services.name', 'like', '%'.$name.'%'))
            ->when($this->filters['search'], fn($query, $search) => $query->where('services.name', 'like', '%'.$search.'%'));

        return $this->applySorting($query);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function resetField()
    {
        $this->service_id = '';
        $this->code ='';
        $this->name ='';
        $this->category_id ='';
        $this->type_id ='';
        $this->selectCategory = false;
        $this->wip_id = 0;
        $this->cogs_id = 0;
        $this->advance_account_id = 0;
        $this->expense_id = 0;
        $this->wips = getAccountByType(5);
        $this->advances = getAccountByType(3);
        $this->cogs = getAccountByType(17);
        $this->expenses = getAccountByType(18);
    }

    public function render()
    {
        return view('livewire.general.services',[
            'services' => $this->rows,
            'categorys' => Category::select(DB::raw('id,concat(code," - ", name) as name'))->get(),
        ]);
    }

    public function create()
    {
        $this->useCachedRows();

        if ($this->editing->getKey()) $this->editing = $this->makeBlankTransaction();
        $this->resetField();
        $this->showEditModal = true;
    }

    public function closeModal()
    {
        $this->showEditModal = false;
    }
    
    public function delete(Service $service)
    {
        $service->delete();
        $this->confirmingDeletion = false;
        session()->flash('message', 'Bank Deleted Successfully');
    }

    public function confirmingDeletion( $id) 
    {
        $this->confirmingDeletion = $id;
    }

    public function edit(Service $service)
    {
        $this->useCachedRows();

        if ($this->editing->isNot($service)) $this->editing = $service;
        $this->service_id = $service->id;
        $this->code = $service->code;
        $this->name = $service->name;
        $this->category_id = $service->category_id;
        $this->selectCategory = $service->type_id;
        /* if($service->type_id == 1){
            $this->selectCategory = true;
        }else{
            $this->selectCategory = false;
        } */
        $this->wips = getAccountByType(5);
        $this->wip_id = $service->wip_id;
        $this->advances = getAccountByType(3);
        $this->advance_account_id = $service->advance_account_id;
        $this->cogs = getAccountByType(17);
        $this->cogs_id = $service->cogs_id;
        $this->expenses = getAccountByType(18);
        $this->expense_id = $service->expense_id;
        $this->showEditModal = true;
        //$this->updateMode = 2;
    }

    public function save()
    {
        $this->validate();
        try {
            $this->editing->save();
            $data = [
                'category_id' => $this->category_id,
                'code' => $this->code,
                'name' => $this->name,
                'type_id' => $this->selectCategory,
                'advance_account_id' => $this->advance_account_id,
                'wip_id' => $this->wip_id,
                'cogs_id' => $this->cogs_id,
                'expense_id' => $this->expense_id,
            ];

            if($this->service_id == null){
                Service::create($data);
                $this->showEditModal = false;
                $this->dispatchBrowserEvent('alert',[
                    'type'=>'success',
                    'message'=>"Service Created Successfully!!"
                ]);
            }else{
                $services = Service::find($this->service_id);
                $services->update($data);
                $this->showEditModal = false;
                $this->dispatchBrowserEvent('alert',[
                    'type'=>'success',
                    'message'=>"Service Updated Successfully!!"
                ]);
            } 
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"Something goes wrong while creating service!!"
            ]);
        }
    }

    public function downloadExcel()
    {
        return Excel::download(new ChargeCodeExport,'Service Charge Code.xlsx');
    }

    public function downloadPDF()
    {
        $results = Service::all();
        $title = 'Daftar Charge Code';
        $params = [
            'settings' => setSetting(),
            'title'  => $title,
            'results' => $results,
        ];
        $pdf = PDF::loadView('reports.generals.charge-codes.pdf', $params)->output();
        return response()->streamDownload(
            fn () => print($pdf),
            $title.'.pdf'
        );
    }
}
