<?php

namespace App\Http\Livewire\General;

use App\Exports\General\UnitExport;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\General\Unit;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class Units extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;

    public $code, $name, $unit_id;
    
    public $showDeleteModal = false;
    public $showEditModal = false;
    public $showFilters = false;
    public $confirmingDeletion = false;
    public Unit $editing;
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
        return Unit::make(['status' => 0]);
    }

    public function getRowsQueryProperty()
    {
        $query = Unit::query()
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
        return view('livewire.general.units',[
            'units' => $this->rows,
        ]);
    }

    public function create()
    {
        $this->useCachedRows();

        if ($this->editing->getKey()) $this->editing = $this->makeBlankTransaction();
        $this->category_id = '';
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
                'message'=>"Unit Created Successfully!!"
            ]);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"Something goes wrong while creating unit!!"
            ]);
        }
    }


    public function edit(Unit $unit)
    {
        $this->useCachedRows();

        if ($this->editing->isNot($unit)) $this->editing = $unit;
        $this->unit_id = $unit->id;
        $this->showEditModal = true;
    }

    public function closeModal()
    {
        $this->showEditModal = false;
    }

    public function delete(Unit $unit)
    {
        $unit->delete();
        $this->confirmingDeletion = false;
        session()->flash('message', 'Unit Deleted Successfully');
    }

    public function confirmingDeletion($id) 
    {
        $this->confirmingDeletion = $id;
    }

    public function downloadExcel()
    {
        return Excel::download(new UnitExport,'Satuan.xlsx');
    }

    public function downloadPDF()
    {
        $results = Unit::all();
        $title = 'Daftar Satuan';
        $params = [
            'settings' => setSetting(),
            'title'  => $title,
            'results' => $results,
        ];
        $pdf = PDF::loadView('reports.generals.units.pdf', $params)->output();
        return response()->streamDownload(
            fn () => print($pdf),
            $title.'.pdf'
        );
    }
}
