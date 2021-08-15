<?php

namespace App\Http\Livewire\Accounting\MataUang;

use App\Exports\Accounting\CurrencyExport;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\Accounting\Currency;
use App\Models\Accounting\CurrencyDefaultAccount;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class Currencies extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;

    public $code, $name, $code_flag, $rate, $currenci_id;
    
    public $setting_id,$currency_default_account_id , $payable_id, $receivable_id, $dp_purchase_id, $dp_sales_id, $realize_id, $unrealize_id, $currDefault;
    public $showDeleteModal = false;
    public $showEditModal = false;
    public $showCurrencyDefaultModal = false;
    public $confirmingDeletion = false;
    public $confirmingSetDefault = false;
    public $showFilters = false;
    public Currency $editing;
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
            'editing.rate' => 'required',
            'editing.code_flag' => 'nullable',
        ]; 
    }

    public function mount() { $this->editing = $this->makeBlankTransaction(); }
    public function updatedFilters() { $this->resetPage(); }

    public function toggleShowFilters()
    {
        $this->useCachedRows();

        $this->showFilters = ! $this->showFilters;
    }

    public function edit(Currency $currency)
    {
        $this->useCachedRows();

        if ($this->editing->isNot($currency)) $this->editing = $currency;
        $this->currenci_id = $currency->id;
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
                'message'=>"Currencies Created Successfully!!"
            ]);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"Something goes wrong while creating currencies!!"
            ]);
        }
    }

    public function resetFilters() { $this->reset('filters'); }

    public function makeBlankTransaction()
    {
        return Currency::make(['rate' => 1, 'status' => 0]);
    }

    public function getRowsQueryProperty()
    {
        $results = Currency::select(DB::raw('id,code,name,rate,code_flag,is_default,status,ifnull((select id from currency_default_accounts where currency_id=currencies.id),0) as defaultcurr'));

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

    public function create()
    {
        $this->useCachedRows();

        if ($this->editing->getKey()) $this->editing = $this->makeBlankTransaction();
        $this->currenci_id = '';
        $this->showEditModal = true;
    }

    public function closeModal()
    {
        $this->showEditModal = false;
    }

    public function delete(Currency $currency)
    {
        $currency->delete();
        $this->confirmingDeletion = false;
        session()->flash('message', 'Currency Deleted Successfully');
    }

    public function confirmingDeletion( $id) 
    {
        $this->confirmingDeletion = $id;
    }
    
    public function render()
    {
        return view('livewire.accounting.mata-uang.currencies', [
            'currencies' => $this->rows,
        ]);
    }

    public function resetFieldDefaultCurrency()
    {
        $setting = setSetting();
        $this->setting_id = $setting->id;
        $this->payable_id = 0;
        $this->receivable_id = 0;
        $this->dp_purchase_id = 0;
        $this->dp_sales_id = 0;
        $this->realize_id = 0;
        $this->unrealize_id = 0;
    }

    public function addDefaultCurrency(Currency $currency)
    {
        $this->resetFieldDefaultCurrency();
        $this->currenci_id = $currency->id;
        $this->currency_default_account_id = '';
        $this->code = $currency->code;
        $this->showCurrencyDefaultModal = true;
    }

    public function viewDefaultCurrency(CurrencyDefaultAccount $currencyDefaultAccount)
    {
        $this->resetFieldDefaultCurrency();
        $this->currency_default_account_id = $currencyDefaultAccount->id;
        $curr = Currency::find($currencyDefaultAccount->currency_id);
        $this->code = $curr->code;
        $this->payable_id = $currencyDefaultAccount->payable_id;
        $this->receivable_id = $currencyDefaultAccount->receivable_id;
        $this->dp_purchase_id = $currencyDefaultAccount->dp_purchase_id;
        $this->dp_sales_id = $currencyDefaultAccount->dp_sales_id;

        $this->showCurrencyDefaultModal = true;
    }

    public function saveDefaultCurrency()
    {
        try {
            if($this->currency_default_account_id == null){
                $data = [
                    'setting_id' => $this->setting_id,
                    'currency_id' => $this->currenci_id,
                    'payable_id' => $this->payable_id,
                    'receivable_id' => $this->receivable_id,
                    'dp_purchase_id' => $this->dp_purchase_id,
                    'dp_sales_id' => $this->dp_sales_id,
                ];
                CurrencyDefaultAccount::create($data);
            }else{
                $data = [
                    'payable_id' => $this->payable_id,
                    'receivable_id' => $this->receivable_id,
                    'dp_purchase_id' => $this->dp_purchase_id,
                    'dp_sales_id' => $this->dp_sales_id,
                ];
                $currDef = CurrencyDefaultAccount::find($this->currency_default_account_id);
                $currDef->update($data);
            }
            $this->showCurrencyDefaultModal = false;

            if($this->currency_default_account_id == null){
                $this->dispatchBrowserEvent('alert',[
                    'type'=>'success',
                    'message'=>"Default Currency Successfully!!"
                ]);
            }else{
                $this->dispatchBrowserEvent('alert',[
                    'type'=>'success',
                    'message'=>"Default Currency Successfull to update!!"
                ]);
            }
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"Something goes wrong while create currency default!!"
            ]);
        }
    }

    public function closeDefault()
    {
        $this->showCurrencyDefaultModal = false;
    }

    public function confirmingSetDefault($id) 
    {
        $this->confirmingSetDefault = $id;
    }

    public function setDefaultCurrency($id)
    {
        try {
            //Back to is default 0
            Currency::where('is_default', '>', 0)->update(['is_default' => 0]);
            //change new default currency
            $curr = Currency::find($id);
            $curr->is_default = 1;
            $curr->save();
            $this->confirmingSetDefault=false;
            
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Set Default Currency Successfully!!"
            ]);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"Something goes wrong while change set currency default!!"
            ]);
        }
    }

    public function downloadExcel()
    {
        return Excel::download(new CurrencyExport,'Currency List.xlsx');
    }

    public function downloadPDF()
    {
        $results = Currency::all();
        $title = 'Daftar Mata Uang';
        $params = [
            'settings' => setSetting(),
            'title'  => $title,
            'results' => $results,
        ];
        $pdf = PDF::loadView('reports.accountings.currencys.pdf', $params)->output();
        return response()->streamDownload(
            fn () => print($pdf),
            $title.'.pdf'
        );
    }
}
