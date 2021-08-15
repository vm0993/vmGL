<?php

namespace App\Http\Livewire\Projects;

use App\Exports\Project\ContractExport;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\Projects\Project;
use App\Models\Projects\ProjectOrder;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class Projects extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;

    public $projs, $code, $name, $ledger_id,$contract_no, $contract_title, $contract_amount, $contract_balance, $project_id, $project_order_id;
    
    //Mapping Project Order
    public $projOrders, $order_no,$order_date, $order_description,$order_amount;
    public $showDeleteModal = false;
    public $showEditModal = false;
    public $showFilters = false;
    public $showProject = 0;
    public $confirmingDeletion = false;
    public Project $editing;
    public ProjectOrder $order;
    public $projectOrders;
    protected $queryString = ['sorts'];
    public $filters = [
        'search' => '',
        'code' => '',
        'name' => '',
        'ledger_id' => '',
        'contract_no' => '',
    ];

    protected $listeners = ['refreshTransactions' => '$refresh'];

    public function rules() { 
        return [
            'editing.code' => 'required|min:2',
            'editing.name' => 'required',
            'editing.ledger_id' => 'required',
            'editing.contract_no' => 'required',
            'editing.contract_title' => 'nullable',
            'editing.contract_amount' => 'required',
        ]; 
    }

    public function mount() { $this->editing = $this->makeBlankTransaction(); }
    public function updatedFilters() { $this->resetPage(); }

    public function toggleShowFilters()
    {
        $this->useCachedRows();

        $this->showFilters = ! $this->showFilters;
    }

    public function resetFieldOrder()
    {
        $this->project_id = 0;
        $this->order_amount =0;
        $this->order_no='';
        $this->order_description = '';
        $this->order_date = '';
    }

    public function addOrder(Project $projs)
    {
        //$projs = Project::find($id);
        $this->resetFieldOrder();
        $this->project_id = $projs->id;
        $this->contract_balance = $projs->contract_balance;
        $this->showProject = 1;
    }

    public function saveOrder()
    {
        try {
            $this->validate([
                'order_no' => 'required',
                'order_date' => 'required',
            ]);
    
            $data = [
                'project_id' => $this->project_id,
                'order_no' => $this->order_no,
                'order_date' => $this->order_date,
                'order_description' => $this->order_description,
                'order_amount' => $this->order_amount,
                'order_balance' => $this->contract_balance - $this->order_amount,
            ];
    
            if($this->project_order_id == null ){
                ProjectOrder::create($data);
            }else{
                $projOrder = ProjectOrder::find($this->project_order_id);
                $projOrder->update($data);
            }

            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Project Order Submit Successfully!!"
            ]);

            $this->showProject = 0;
        } catch (\Throwable $th) {
            //throw $th;
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"Something goes wrong while submited!!"
            ]);
        }
    }

    public function edit(Project $project)
    {
        $this->useCachedRows();

        if ($this->editing->isNot($project)) $this->editing = $project;
        $this->project_id = $project->id;
        $this->showEditModal = true;
    }

    public function save()
    {
        $this->validate();
        try {

            $this->editing->save();
            $this->showEditModal = false;
            $this->showProject = 0;
            
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Project Submit Successfully!!"
            ]);
            
        } catch (\Throwable $th) {
            //throw $th;
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"Something goes wrong while project!!"
            ]);
        }
    }

    public function resetFilters() { $this->reset('filters'); }

    public function confirmDeletion($id)
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
        return Project::make(['ledger_id' => 0, 'status' => 0]);
    }

    public function getRowsQueryProperty()
    {
        $results = Project::select(DB::raw('projects.id,projects.code,projects.name,projects.ledger_id,ledgers.code as clientcode,ledgers.name as clientname,projects.contract_no,projects.contract_title,projects.contract_amount,projects.contract_balance,projects.status'))
                    ->join('ledgers','ledgers.id','=','projects.ledger_id');

        $query = $results
            ->when($this->filters['code'], fn($query, $code) => $query->where('projects.code', 'like', '%'.$code.'%'))
            ->when($this->filters['name'], fn($query, $name) => $query->where('projects.name', 'like', '%'.$name.'%'))
            ->when($this->filters['ledger_id'], fn($query, $ledger_id) => $query->where('projects.ledger_id', '=', $ledger_id))
            ->when($this->filters['contract_no'], fn($query, $contract_no) => $query->where('projects.contract_no', 'like', '%'.$contract_no.'%'))
            ->when($this->filters['search'], fn($query, $search) => $query->where('projects.contract_no', 'like', '%'.$search.'%'));

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

        if($this->editing->getKey()) $this->editing = $this->makeBlankTransaction();
        $this->project_id = '';
        $this->showEditModal = true;
    }

    public function closeOrder()
    {
        $this->showProject = 0;
    }

    public function closeModal()
    {
        $this->showEditModal = false;
    }

    public function delete(Project $project)
    {
        $project->delete();
        $this->confirmingDeletion = false;
        session()->flash('message', 'Bank Deleted Successfully');
    }

    public function confirmingDeletion($id) 
    {
        $this->confirmingDeletion = $id;
    }

    public function render()
    {
        return view('livewire.projects.projects', [
            'projects' => $this->rows
        ]);
    }

    public function downloadExcel()
    {
        return Excel::download(new ContractExport,'Project List.xlsx');
    }

    public function downloadPDF()
    {
        $results = Project::with('ledger')->get();
        $title = 'Daftar Proyek';
        $params = [
            'settings' => setSetting(),
            'title'  => $title,
            'results' => $results,
        ];
        $pdf = PDF::loadView('reports.projects.contracts.pdf', $params)->setPaper('a4')->output();
        return response()->streamDownload(
            fn () => print($pdf),
            $title.'.pdf'
        );
    }
}
