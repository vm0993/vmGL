<?php

namespace App\Http\Livewire\General;

use App\Exports\General\PersonelExport;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\General\Personel;
use Livewire\Component;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class Personils extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;

    public $code, $name, $address, $phone_no, $amount, $personil_id;
    
    public $showDeleteModal = false;
    public $showEditModal = false;
    public $showFilters = false;
    public $confirmingDeletion = false;
    public Personel $editing;
    protected $queryString = ['sorts'];
    public $filters = [
        'search' => '',
        'code' => '',
        'name' => '',
    ];

    protected $listeners = ['refreshTransactions' => '$refresh'];

    public function rules() { 
        return [
            'editing.code' => 'required|min:2',
            'editing.name' => 'required',
            'editing.address' => 'nullable',
            'editing.phone_no' => 'nullable',
        ]; 
    }

    public function mount() { $this->editing = $this->makeBlankTransaction(); }
    public function updatedFilters() { $this->resetPage(); }

    public function toggleShowFilters()
    {
        $this->useCachedRows();

        $this->showFilters = ! $this->showFilters;
    }

    public function edit(Personel $personel)
    {
        $this->useCachedRows();

        if ($this->editing->isNot($personel)) $this->editing = $personel;
        $this->personil_id = $personel->id;
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
                'message'=>"Personil Created Successfully!!"
            ]);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"Something goes wrong while creating personil!!"
            ]);
        }
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
        return Personel::make(['amount' => 0, 'status' => 0]);
    }

    public function getRowsQueryProperty()
    {
        $query = Personel::query()
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

    public function create()
    {
        $this->useCachedRows();

        if ($this->editing->getKey()) $this->editing = $this->makeBlankTransaction();
        $this->personil_id = '';
        $this->showEditModal = true;
    }

    public function closeModal()
    {
        $this->showEditModal = false;
    }

    public function delete(Personel $personel)
    {
        $personel->delete();
        $this->confirmingDeletion = false;
        session()->flash('message', 'Bank Deleted Successfully');
    }

    public function confirmingDeletion( $id) 
    {
        $this->confirmingDeletion = $id;
    }

    public function render()
    {
        return view('livewire.general.personils', [
            'personels' => $this->rows,
        ]);
    }

    public function downloadExcel()
    {
        return Excel::download(new PersonelExport,'Personel.xlsx');
    }

    public function downloadPDF()
    {
        $results = Personel::all();
        $title = 'Daftar Pegawai';
        $params = [
            'settings' => setSetting(),
            'title'  => $title,
            'results' => $results,
        ];
        $pdf = PDF::loadView('reports.generals.personels.pdf', $params)->output();
        return response()->streamDownload(
            fn () => print($pdf),
            $title.'.pdf'
        );
    }
}
