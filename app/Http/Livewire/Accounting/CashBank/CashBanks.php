<?php

namespace App\Http\Livewire\Accounting\CashBank;

use App\Exports\Accounting\CashBankExport;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\Accounting\Account;
use App\Models\Accounting\CashBank;
use App\Models\Accounting\CashBankDetail;
use App\Models\Accounting\GeneralLedger;
use App\Models\Accounting\GeneralLedgerDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class CashBanks extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;

    public $cashbanks, $code, $source_account_id, $transaction_date, $description, $total, $cashbank_id;
    
    public $showDeleteModal = false;
    public $showEditModal = false;
    public $confirmingDeletion = false;
    //public $sourceAccounts;
    public $showFilters = false;
    public $selectCashBankType = false;
    public $updateMode = 0;
    public $sourceAccounts = [];
    public $accounts = [];
    public $allJurnals = [];
    public $allAccounts = [];
    public CashBank $editing;
    protected $queryString = ['sorts'];

    public $filters = [
        'search' => '',
        'amount' => '',
        'description' => '',
        'start_date' => '',
        'end_date' => '',
    ];

    protected $listeners = ['refreshTransactions' => '$refresh'];

    public function rules() { 
        return [
            'module_id' => 'required',
            'code' => 'required|min:3',
            'transaction_date' => 'required',
            'source_account_id' => 'required',
            'description' => 'nullable',
        ]; 
    }

    public function mount() { $this->editing = $this->makeBlankTransaction(); }
    public function updatedFilters() { $this->resetPage(); }

    public function addAccount()
    {
        $this->allJurnals[] = ['account_id' => 0,'cost_id'=> 0, 'amount' => 0,'memo' => ''];
    }

    public function backCashBank()
    {
        $this->updateMode = 0;
        $this->render();
    }

    public function removeAccount($index)
    {
        unset($this->allJurnals[$index]);
        $this->allJurnals = array_values($this->allJurnals);
    }

    public function autoNumber()
    {
        $period = Carbon::parse($this->transaction_date)->format('ym');
        $lastNo = CashBank::select(DB::raw('max(RIGHT(code, 4)) as result'))
                    ->whereYear('transaction_date',Carbon::parse($this->transaction_date)->format('Y'))
                    ->whereMonth('transaction_date',Carbon::parse($this->transaction_date)->format('m'))
                    ->groupByRaw('date_format(transaction_date,"%y%m") = "'.$period.'" ')
                    ->orderBy('id','desc')
                    ->get()
                    ->first();

        if(!empty($lastNo)){
            $maxNo =  $lastNo->result + 1;
        }else{
            $maxNo = 1;
        }
        $length_no = 4;
        $tmpNo = sprintf('%0'.$length_no.'s', $maxNo);

        if($this->selectCashBankType == true){
            $this->code = 'CBO'.Carbon::parse($this->transaction_date)->format('ym').$tmpNo;
        }else{
            $this->code = 'CBI'.Carbon::parse($this->transaction_date)->format('ym').$tmpNo;
        }
    }

    public function toggleShowFilters()
    {
        $this->useCachedRows();
        $this->showFilters = ! $this->showFilters;
    }

    public function edit(CashBank $cashbank)
    {
        $this->useCachedRows();
        if($this->editing->isNot($cashbank)) $this->editing = $cashbank;
        $this->cashbank_id = $cashbank->id;
        $this->updateMode = 2;
        $this->showEditModal = true;
        $this->source_account_id = $cashbank->source_account_id;
        $this->code = $cashbank->code;
        $this->transaction_date = $cashbank->transaction_date;
        $this->description = $cashbank->description;
        $this->sourceAccounts = Account::select(DB::raw('id,concat(account_no," - ",account_name) as name'))->where([['status',0],['account_type',1],['is_jurnal',0]])->get();
        $this->allJurnals = CashBankDetail::select(DB::raw('id,account_id,cost_id,amount,memo'))->where('cash_bank_id',$this->cashbank_id)->get()->toArray();
        $this->allAccounts = Account::select(DB::raw('id,account_no,account_name'))
                                ->where([
                                    ['status',0],
                                    ['is_jurnal',0]
                                ])
                                ->get();
    }

    public function save()
    {
        $this->validate([
            'code' => 'required',
            'transaction_date' => 'required',
        ]);

        $data = [
            'module_id' => 11,
            'cash_bank_type' => $this->selectCashBankType,
            'code' => $this->code,
            'source_account_id' => $this->source_account_id,
            'transaction_date' => $this->transaction_date,
            'description' => $this->description,
        ];

        if($this->cashbank_id == null){
            $cashbanks = CashBank::create($data);
            foreach (array_values($this->allJurnals) as $detail) {
                $detail = array(
                    'cash_bank_id' => $cashbanks->id,
                    'account_id' => $detail['account_id'],
                    'cost_id' => 0,
                    'amount' => $detail['amount'],
                    'memo' => $detail['memo']
                );
                CashBankDetail::create($detail);
            }
            //transfer to GL
            $dataGL = [
                'module_id' => 11,
                'code' => $this->code,
                'transaction_date' => $this->transaction_date,
                'description' => $this->description,
            ];
            $glResult = GeneralLedger::where('code',$this->code)->first();
            if(empty($glResult)){
                $glInsert = GeneralLedger::create($dataGL);
                $cbDtl1 = CashBankDetail::select(DB::raw('cash_bank_details.account_id,case when cash_banks.cash_bank_type =1 then cash_bank_details.amount else 0 end as debet,case when cash_banks.cash_bank_type = 0 then cash_bank_details.amount else 0 end as credit,cash_bank_details.cost_id,cash_bank_details.memo'))
                            ->join('cash_banks','cash_banks.id','=','cash_bank_details.cash_bank_id')
                            ->where('cash_banks.code',$this->code);

                $cbDtl2 = CashBank::select(DB::raw('cash_banks.source_account_id as account_id,case when cash_banks.cash_bank_type =1 then 0 else cash_banks.total end as debet,case when cash_banks.cash_bank_type = 0 then 0 else cash_banks.total end as credit,(select cost_id from cash_bank_details where cash_bank_id=cash_banks.id limit 1) as cost_id,cash_banks.description as memo'))
                            ->where('code',$this->code);

                $joinSQL = $cbDtl1->union($cbDtl2);

                $cashBankDetail = CashBank::select(DB::raw('a.account_id,a.debet,a.credit,a.cost_id,a.memo'))
                                    ->from(DB::raw('('.$joinSQL->toSql().') as a '))
                                    ->mergeBindings($joinSQL->getQuery())
                                    ->get();

                foreach ($cashBankDetail as $value) {
                    # code...
                    $dataDetail = [
                        'general_ledger_id' => $glResult->id,
                        'account_id' => $value->account_id,
                        'debet' => $value->debet,
                        'credit' => $value->credit,
                        'cost_id' => $value->cost_id,
                        'memo' => $value->memo,
                    ];
                    GeneralLedgerDetail::create($dataDetail);
                }
            }else{
                $glResult->update($dataGL);
                //delete old record
                CashBankDetail::where('general_ledger_id',$glResult->id)->delete();
                //insert new record
                $cbDtl1 = CashBankDetail::select(DB::raw('cash_bank_details.account_id,case when cash_banks.cash_bank_type =1 then cash_bank_details.amount else 0 end as debet,case when cash_banks.cash_bank_type = 0 then cash_bank_details.amount else 0 end as credit,cash_bank_details.cost_id,cash_bank_details.memo'))
                            ->join('cash_banks','cash_banks.id','=','cash_bank_details.cash_bank_id')
                            ->where('cash_banks.code',$this->code);

                $cbDtl2 = CashBank::select(DB::raw('cash_banks.source_account_id as account_id,case when cash_banks.cash_bank_type =1 then 0 else cash_banks.total end as debet,case when cash_banks.cash_bank_type = 0 then 0 else cash_banks.total end as credit,(select cost_id from cash_bank_details where cash_bank_id=cash_banks.id limit 1) as cost_id,cash_banks.description as memo'))
                            ->where('code',$this->code);

                $joinSQL = $cbDtl1->union($cbDtl2);

                $cashBankDetail = CashBank::select(DB::raw('a.account_id,a.debet,a.credit,a.cost_id,a.memo'))
                                    ->from(DB::raw('('.$joinSQL->toSql().') as a '))
                                    ->mergeBindings($joinSQL->getQuery())
                                    ->get();

                foreach ($cashBankDetail as $value) {
                    # code...
                    $dataDetail = [
                        'general_ledger_id' => $glResult->id,
                        'account_id' => $value->account_id,
                        'debet' => $value->debet,
                        'credit' => $value->credit,
                        'cost_id' => $value->cost_id,
                        'memo' => $value->memo,
                    ];
                    GeneralLedgerDetail::create($dataDetail);
                }
            }
            //end transfer to gl
        }else{
            $cashbanks = CashBank::find($this->cashbank_id);
            $cashbanks->update($data);
            CashBankDetail::where('cash_bank_id',$this->cashbank_id)->delete();
            foreach (array_values($this->allJurnals) as $detail) {
                $detail = array(
                    'cash_bank_id' => $cashbanks->id,
                    'account_id' => $detail['account_id'],
                    'cost_id' => 0,
                    'amount' => $detail['amount'],
                    'memo' => $detail['memo']
                );
                CashBankDetail::create($detail);
            }
            //transfer to GL
            $dataGL = [
                'module_id' => 11,
                'code' => $this->code,
                'transaction_date' => $this->transaction_date,
                'description' => $this->description,
            ];
            $glResult = GeneralLedger::where('code',$this->code)->first();
            if(empty($glResult)){
                $glInsert = GeneralLedger::create($dataGL);
                $cbDtl1 = CashBankDetail::select(DB::raw('cash_bank_details.account_id,case when cash_banks.cash_bank_type =1 then cash_bank_details.amount else 0 end as debet,case when cash_banks.cash_bank_type = 0 then cash_bank_details.amount else 0 end as credit,cash_bank_details.cost_id,cash_bank_details.memo'))
                            ->join('cash_banks','cash_banks.id','=','cash_bank_details.cash_bank_id')
                            ->where('cash_banks.code',$this->code);

                $cbDtl2 = CashBank::select(DB::raw('cash_banks.source_account_id as account_id,case when cash_banks.cash_bank_type =1 then 0 else cash_banks.total end as debet,case when cash_banks.cash_bank_type = 0 then 0 else cash_banks.total end as credit,(select cost_id from cash_bank_details where cash_bank_id=cash_banks.id limit 1) as cost_id,cash_banks.description as memo'))
                            ->where('code',$this->code);

                $joinSQL = $cbDtl1->union($cbDtl2);

                $cashBankDetail = CashBank::select(DB::raw('a.account_id,a.debet,a.credit,a.cost_id,a.memo'))
                                    ->from(DB::raw('('.$joinSQL->toSql().') as a '))
                                    ->mergeBindings($joinSQL->getQuery())
                                    ->get();

                foreach ($cashBankDetail as $value) {
                    # code...
                    $dataDetail = [
                        'general_ledger_id' => $glInsert->id,
                        'account_id' => $value->account_id,
                        'debet' => $value->debet,
                        'credit' => $value->credit,
                        'cost_id' => $value->cost_id,
                        'memo' => $value->memo,
                    ];
                    GeneralLedgerDetail::create($dataDetail);
                }
            }else{
                $glResult->update($dataGL);
                //delete old record
                GeneralLedgerDetail::where('general_ledger_id',$glResult->id)->delete();
                //insert new record
                $cbDtl1 = CashBankDetail::select(DB::raw('cash_bank_details.account_id,case when cash_banks.cash_bank_type =1 then cash_bank_details.amount else 0 end as debet,case when cash_banks.cash_bank_type = 0 then cash_bank_details.amount else 0 end as credit,cash_bank_details.cost_id,cash_bank_details.memo'))
                            ->join('cash_banks','cash_banks.id','=','cash_bank_details.cash_bank_id')
                            ->where('cash_banks.code',$this->code);

                $cbDtl2 = CashBank::select(DB::raw('cash_banks.source_account_id as account_id,case when cash_banks.cash_bank_type =1 then 0 else cash_banks.total end as debet,case when cash_banks.cash_bank_type = 0 then 0 else cash_banks.total end as credit,(select cost_id from cash_bank_details where cash_bank_id=cash_banks.id limit 1) as cost_id,cash_banks.description as memo'))
                            ->where('code',$this->code);

                $joinSQL = $cbDtl1->union($cbDtl2);

                $cashBankDetail = CashBank::select(DB::raw('a.account_id,a.debet,a.credit,a.cost_id,a.memo'))
                                    ->from(DB::raw('('.$joinSQL->toSql().') as a '))
                                    ->mergeBindings($joinSQL->getQuery())
                                    ->get();

                foreach ($cashBankDetail as $value) {
                    # code...
                    $dataDetail = [
                        'general_ledger_id' => $glResult->id,
                        'account_id' => $value->account_id,
                        'debet' => $value->debet,
                        'credit' => $value->credit,
                        'cost_id' => $value->cost_id,
                        'memo' => $value->memo,
                    ];
                    GeneralLedgerDetail::create($dataDetail);
                }
            }
            //end transfer to gl
        }

        $this->updateMode = 0;
        $this->dispatchBrowserEvent('alert',[
            'type' => 'success',
            'message' => "Cash Bank Transaction Successfull to saved!!"
        ]);
        $this->render();
    }

    public function resetFilters() { $this->reset('filters'); }

    public function makeBlankTransaction()
    {
        return CashBank::make(['source_account_id' => 0, 'status' => 0]);
    }

    public function getRowsQueryProperty()
    {
        $results = CashBank::select(DB::raw('cash_banks.id,cash_banks.source_account_id,concat(accounts.account_no," - ",accounts.account_name) as accountName,cash_banks.code,cash_banks.transaction_date,cash_banks.description,cash_banks.total'))
                    ->join('accounts','accounts.id','=','cash_banks.source_account_id');

        $query = $results
            ->when($this->filters['amount'], fn($query, $code) => $query->where('amount', 'like', '%'.$code.'%'))
            ->when($this->filters['description'], fn($query, $name) => $query->where('description', 'like', '%'.$name.'%'))
            ->when($this->filters['start_date'], fn($query, $startDate) => $query->where('transaction_date', '>=', ''.$startDate.''))
            ->when($this->filters['end_date'], fn($query, $endDate) => $query->where('transaction_date', '<=', ''.$endDate.''))
            ->when($this->filters['search'], fn($query, $search) => $query->where('description', 'like', '%'.$search.'%'));

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
        $this->cashbank_id = '';
        $this->allAccounts = Account::select(DB::raw('id,account_no,account_name'))->where([['status',0],['is_jurnal',0]])->get();
        $this->sourceAccounts = Account::select(DB::raw('id,account_no,account_name'))->where([['status',0],['account_type',1],['is_jurnal',0]])->get();
        $this->allJurnals = [
            ['account_id' => 0, 'amount' => 0, 'memo' => '']
        ];
        $this->updateMode = 1;
        $this->showEditModal = true;
    }

    public function closeModal()
    {
        $this->showEditModal = false;
    }

    public function delete(CashBank $cashbank)
    {
        $cashbank->delete();
        $this->confirmingDeletion = false;
        session()->flash('message', 'Cash Bank Deleted Successfully');
    }

    public function confirmingDeletion( $id) 
    {
        $this->confirmingDeletion = $id;
    }

    public function render()
    {
        return view('livewire.accounting.cash-bank.cash-banks',[
            'kasbanks' => $this->rows,
            $this->showEditModal = false,
            'updateMode' => $this->updateMode,
            'sourceAccounts' => Account::select(DB::raw('id,account_no,account_name'))->where([['status',0],['account_type',1],['is_jurnal',0]])->get(),
        ]);
    }

    public function preview($id)
    {
        $kasBank = CashBank::with(['account','cashBank'])->findOrFail($id);
        $params = [
            'settings' => setSetting(),
            'title'  => 'Cash Bank Voucher',
            'kasBank' => $kasBank,
        ];
        $pdf = PDF::loadView('reports.accountings.cashbanks.standard', $params)->output();
        return response()->streamDownload(
            fn () => print($pdf),
            $kasBank->code.'.pdf'
        );
    }

    public function downloadExcel()
    {
        return Excel::download(new CashBankExport($this->filters['start_date'], $this->filters['end_date']),'Cash Bank List.xlsx');
    }

    public function downloadPDF()
    {
        $results = CashBank::where([
                        ['cash_banks.transaction_date','>=',Carbon::parse($this->filters['start_date'])->format('Y-m-d')],
                        ['cash_banks.transaction_date','<=',Carbon::parse($this->filters['end_date'])->format('Y-m-d')]
                    ])
                    ->with('cashBank')
                    ->get();

        $title = 'Daftar Kas Bank';
        $params = [
            'settings' => setSetting(),
            'title'  => $title,
            'results' => $results,
            'periodeAwal' => $this->filters['start_date'],
            'periodeAkhir' => $this->filters['end_date'],
        ];
        $pdf = PDF::loadView('reports.accountings.cashbanks.pdf', $params)->output();
        return response()->streamDownload(
            fn () => print($pdf),
            $title.'.pdf'
        );
    }
}
