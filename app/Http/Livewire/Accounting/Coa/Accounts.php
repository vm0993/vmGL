<?php

namespace App\Http\Livewire\Accounting\Coa;

use App\Exports\Accounting\AccountExport;
use App\Helpers\FinanceHelper;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Imports\AccountImport;
use App\Models\Accounting\Account;
use App\Models\Upload;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class Accounts extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows, WithFileUploads;

    public $account_no, $account_name, $account_type, $group_account_id, $is_jurnal,$bank_id,$account_balance, $account_id;
    public $excelFile;
    public $fileName;
    public $isUploaded = false;

    public $showDeleteModal = false;
    public $confirmingSuspend = false;
    public $confirmingActivate = false;
    public $confirmingDeletion = false;
    public $showEditModal = false;
    public $showImportModal = false;
    public $showFilters = false;
    public Account $editing;
    protected $queryString = ['sorts'];
    public $filters = [
        'search' => '',
        'account_no' => '',
        'account_name' => '',
    ];

    protected $listeners = ['refreshTransactions' => '$refresh'];

    public function rules() { 
        return [
            'editing.account_type' => 'required',
            'editing.account_no' => 'required|min:3',
            'editing.account_name' => 'required',
        ]; 
    }

    public function mount() { $this->editing = $this->makeBlankTransaction(); }
    public function updatedFilters() { $this->resetPage(); }

    public function toggleShowFilters()
    {
        $this->useCachedRows();

        $this->showFilters = ! $this->showFilters;
    }

    public function edit(Account $account)
    {
        $this->useCachedRows();

        if($this->editing->isNot($account)) $this->editing = $account;
        $this->account_id = $account->id;
        $this->account_no = $account->account_no;
        $this->account_name = $account->account_name;
        $this->account_type = $account->account_type;
        $this->group_account_id = $account->group_account_id;
        $this->showEditModal = true;
    }

    public function save()
    {
        $this->validate();
        try {
            $groupAcc = Account::find($this->group_account_id);
            $data = [
                'account_no' => $this->account_no,
                'account_name' => $this->account_name,
                'account_type' => $this->account_type,
                'group_account_id' => $groupAcc->id,
            ];
            if($this->account_id == null) {
                $result = Account::create($data);
                if($this->group_account_id != null){
                    $groupAcc->is_jurnal= 1;
                    $groupAcc->save();
                }
            }else{
                $result = Account::find($this->account_id);
                $result->update($data);
                if($this->group_account_id != null){
                    $groupAcc->is_jurnal= 1;
                    $groupAcc->save();
                }
            }
            
            $this->showEditModal = false;
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Account Created Successfully!!"
            ]);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"Something goes wrong while creating account!!"
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
        return Account::make(['account_type' => 0, 'status' => 0]);
    }

    public function getRowsQueryProperty()
    {
        $result = Account::orderBy('account_no','asc');
        $query = $result
            ->when($this->filters['account_no'], fn($query, $account_no) => $query->where('account_no', 'like', '%'.$account_no.'%'))
            ->when($this->filters['account_name'], fn($query, $account_name) => $query->where('account_name', 'like', '%'.$account_name.'%'))
            ->when($this->filters['search'], fn($query, $search) => $query->where('account_name', 'like', '%'.$search.'%'));

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
        $this->account_id = '';
        $this->showEditModal = true;
    }

    public function closeModal()
    {
        $this->showEditModal = false;
    }
    
    public function render()
    {
        return view('livewire.accounting.coa.accounts', [
            'accounts' => $this->rows, 'accType' => FinanceHelper::getAccountType()
        ]);
    }

    public function confirmingActivate($id)
    {
        $this->confirmingActivate = $id;
    }

    public function activated(Account $account)
    {
        try {
            //change new default currency
            $account->status = 0;
            $account->save();
            $this->confirmingActivate=false;
            
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Account back to Actice Successfully!!"
            ]);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"Something goes wrong while change active account!!"
            ]);
        }
    }

    public function confirmingSuspend($id) 
    {
        $this->confirmingSuspend = $id;
    }

    public function suspend(Account $account)
    {
        try {
            //change new default currency
            $account->status = 1;
            $account->save();
            $this->confirmingSuspend=false;
            
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Suspend Account Successfully!!"
            ]);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"Something goes wrong while change suspend account!!"
            ]);
        }
    }

    public function importCOA()
    {
        $this->useCachedRows();

        if($this->editing->getKey()) $this->editing = $this->makeBlankTransaction();
        $this->account_id = '';
        $this->showImportModal = true;
    }

    public function closeImport()
    {
        $this->showImportModal = false;
    }

    public function importProcess()
    {
        $this->validate([
            'excelFile' => 'required',
        ]);

        $upload = new Upload();
        $upload->file_name = $this->excelFile->getClientOriginalName();
        $upload->uploaded_at = date("Y-m-d H:i:s");
        $upload->file_size = $this->excelFile->getSize();
        $upload->file_ext = $this->excelFile->getClientOriginalExtension();
        $upload->file_type = $this->excelFile->getClientMimeType();
        $upload->created_at = date("Y-m-d H:i:s");
        $upload->status = "uploaded";
        $upload->save();

        $destinationPath = 'uploads';
        $path = Storage::putFile($destinationPath, $this->excelFile);

        ray($path);

        $import = new AccountImport($upload->id);
        Excel::import($import, $path);

        $this->isUploaded = true;
        $this->showImportModal = false;
        $this->fileName = '';

        //Excel::import(new AccountImport, request()->file('lokasi_file'));

        /* $this->showImportModal = false;
        
        return response()->json([
            'fail' => false,
            'redirect_url' => url('keuangan/kode-akun')
        ]); */
    }

    public function downloadExcel()
    {
        return Excel::download(new AccountExport,'Chart Of Account.xlsx');
    }

    public function downloadPDF()
    {
        $results = Account::all();
        $title = 'Daftar Account';
        $params = [
            'settings' => setSetting(),
            'title'  => $title,
            'results' => $results,
        ];
        $pdf = PDF::loadView('reports.accountings.coas.pdf', $params)->output();
        return response()->streamDownload(
            fn () => print($pdf),
            $title.'.pdf'
        );
    }
}
