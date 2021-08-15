<?php

namespace App\Http\Livewire\General;

use App\Exports\General\SizeExport;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\General\Size;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class Sizes extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;

    public $code, $name, $gravity, $size_id, $sizes;
    
    public $showDeleteModal = false;
    public $showEditModal = false;
    public $showFilters = false;
    public $confirmingDeletion = false;
    public Size $editing;
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
            'editing.gravity' => 'required',
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
        return Size::make(['status' => 0]);
    }

    public function getRowsQueryProperty()
    {
        $query = Size::query()
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
        return view('livewire.general.sizes',[
            'gSize' => $this->rows,
        ]);
    }

    public function create()
    {
        $this->useCachedRows();

        if($this->editing->getKey()) $this->editing = $this->makeBlankTransaction();
        $this->size_id = '';
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
                'message'=>"Size Created Successfully!!"
            ]);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"Something goes wrong while creating size!!"
            ]);
        }
    }

    public function edit(Size $size)
    {
        $this->useCachedRows();

        if ($this->editing->isNot($size)) $this->editing = $size;
        $this->size_id = $size->id;
        $this->showEditModal = true;
    }

    public function closeModal()
    {
        $this->showEditModal = false;
    }

    public function delete(Size $size)
    {
        $size->delete();
        $this->confirmingDeletion = false;
        session()->flash('message', 'Size Deleted Successfully');
    }

    public function confirmingDeletion($id) 
    {
        $this->confirmingDeletion = $id;
    }

    public function downloadExcel()
    {
        return Excel::download(new SizeExport,'Package.xlsx');
    }

    public function downloadPDF()
    {
        $results = Size::all();
        $title = 'Daftar Package Size';
        $params = [
            'settings' => setSetting(),
            'title'  => $title,
            'results' => $results,
        ];
        $pdf = PDF::loadView('reports.generals.sizes.pdf', $params)->output();
        return response()->streamDownload(
            fn () => print($pdf),
            $title.'.pdf'
        );
    }
}
