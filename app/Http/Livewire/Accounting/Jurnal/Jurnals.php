<?php

namespace App\Http\Livewire\Accounting\Jurnal;

use App\Exports\Accounting\JurnalExport;
use PDF;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Jobs\Accounting\PostJurnal;
use App\Models\Accounting\Account;
use App\Models\Accounting\GeneralLedger;
use App\Models\Accounting\GeneralLedgerDetail;
use App\Models\Accounting\Jurnal;
use App\Models\Accounting\JurnalDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Jurnals extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;
    
    public $jurnal, $code, $transaction_date, $description, $total, $status, $jurnal_id;
    public $settings;
    public $updateMode = 0;
    public $showFilters = false;
    public $confirmingDeletion = false;
    public $accounts = [];
    public $allJurnals = [];
    public $allAccounts = [];
    public Jurnal $editing;
    protected $queryString = ['sorts'];
    public $filters = [
        'search' => '',
        'start_date' => '',
        'end_date' => '',
        'code' => '',
        'description' => '',
    ];

    public function rules() { 
        return [ 
            'code' => 'required',
            'transaction_date' => 'required',
            'description' => 'nullable',
        ]; 
    }

    public function mount()
    {
        $this->editing = $this->makeBlankTransaction();
        $this->allAccounts = Account::select('id','account_no','account_name')->where('is_jurnal',0)->get();
        $this->allJurnals = [
            ['account_id' => 0,'cost_id'=> 0, 'debet' => 0,'credit'=> 0, 'memo' => '']
        ];
    }

    public function updatedFilters() { $this->resetPage(); }

    public function toggleShowFilters()
    {
        $this->useCachedRows();
        $this->showFilters = ! $this->showFilters;
    }

    public function resetFilters() { $this->reset('filters'); }

    public function addAccount()
    {
        $this->allJurnals[] = ['account_id' => 0,'cost_id'=> 0, 'debet' => 0,'credit'=> 0, 'memo' => ''];
    }

    public function backIndex()
    {
        $this->updateMode = 0;
        $this->render();
    }

    public function removeJurnal($index)
    {
        unset($this->allJurnals[$index]);
        $this->allJurnals = array_values($this->allJurnals);
    }

    public function makeBlankTransaction()
    {
        return Jurnal::make(['status' => 0,'module_id' => 11]);
    }

    public function getRowsQueryProperty()
    {
        $results = Jurnal::select(DB::raw('id,code,transaction_date,description,total,status,
                case when status=0 then "Non Recuring" when status=1 then "Recurring" end as statusdata '))
                ->orderBy('id','desc');
        
        $query = $results
            ->when($this->filters['code'], fn($query, $code) => $query->where('code', 'like', '%'.$code.'%'))
            ->when($this->filters['description'], fn($query, $description) => $query->where('description', 'like', '%'.$description.'%'))
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

    public function autoNumber()
    {
        $period = Carbon::parse($this->transaction_date)->format('ym');
        $lastNo = Jurnal::select(DB::raw('max(RIGHT(code, 4)) as result'))
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

        $this->code = 'GJ'.Carbon::parse($this->transaction_date)->format('ym').$tmpNo;
    }

    public function render()
    {
        return view('livewire.accounting.jurnal.jurnals',[
            'jurnals' => $this->rows,
            'updateMode' => $this->updateMode
        ]);
    }

    public function sumColumn($columnName)
    {
        $this->totals[$columnName] = array_reduce($this->allJurnals, function($total, $item) use ($columnName) {
            $total += $item[$columnName];

            return $total;
        });
    }

    public function delete(Jurnal $jurnal)
    {
        try {
            $jurnal->delete();
            $this->confirmingDeletion = false;

            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Jurnal Deleted Successfully!!"
            ]);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Something goes wrong while deleting jurnal!!"
            ]);
        }
    }

    public function confirmingDeletion($id) 
    {
        $this->confirmingDeletion = $id;
    }

    public function create()
    {
        $this->resetInputFields();
        $this->allAccounts = Account::select('id','account_no','account_name')->where('is_jurnal',0)->get();
        $this->allJurnals = [
            ['account_id' => 0, 'debet' => 0,'credit'=> 0, 'memo' => '']
        ];
        $this->updateMode = 1;
    }

    private function resetInputFields(){
        $this->code = '';
        $this->transaction_date = '';
        $this->description = '';
        $this->total = 0;
        $this->status = 0;
        $this->jurnal_id = '';
    }

    public function save()
    {
        $this->validate([ //|unique:currencies,code,'.$this->currenci_id
            'code' => 'required',
            'transaction_date' => 'required',
        ]);

        $data = [
            'module_id' => 12,
            'code'   => $this->code,
            'transaction_date'   => $this->transaction_date,
            'description'   => $this->description,
        ];

        if($this->jurnal_id == null){
            $jurnal = Jurnal::create($data);
            foreach (array_values($this->allJurnals) as $detail) {
                $detail = array(
                    'jurnal_id' => $jurnal->id,
                    'account_id' => $detail['account_id'],
                    'cost_id'=>0,
                    'debet'=>$detail['debet'],
                    'credit' => $detail['credit'],
                    'memo'=> $detail['memo']
                );
                JurnalDetail::create($detail);
            }
            //to General Ledger
            $glHeader = GeneralLedger::create($data);

            $glDetail = JurnalDetail::where('jurnal_id',$jurnal->id)->get();
            foreach($glDetail as $detail)
            {
                $transDetail = [
                    'general_ledger_id' => $glHeader->id,
                    'account_id' => $detail->account_id,
                    'cost_id' => $detail->cost_id,
                    'debet' => $detail->debet,
                    'credit' => $detail->credit,
                    'memo' => $detail->memo,
                ];
                GeneralLedgerDetail::create($transDetail);
            }
            //End General Ledger
        }else{
            $jurnal = Jurnal::find($this->jurnal_id);
            $jurnal->update($data);
            JurnalDetail::where('jurnal_id',$this->jurnal_id)->delete();
            foreach (array_values($this->allJurnals) as $detail) {
                $detail = array(
                    'jurnal_id' => $jurnal->id,
                    'account_id' => $detail['account_id'],
                    'cost_id'=>0,
                    'debet'=>$detail['debet'],
                    'credit' => $detail['credit'],
                    'memo'=> $detail['memo']
                );
                JurnalDetail::create($detail);
            }
            //to General Ledger
            $gl_id = Jurnal::find($this->jurnal_id);
            $dataUpd = [
                'module_id' => 12,
                'code' => $gl_id->code,
                'transaction_date' => $gl_id->transaction_date,
                'description' => $gl_id->description,
            ];
            
            $glUpdate = GeneralLedger::where('code',$this->code)->first();
            if(empty($glUpdate)){
               $head =  GeneralLedger::create($dataUpd);
            }else{
                $glUpdate->update($data);
            }
            if(empty($glUpdate)){
                $glID = $head->id;
            }else{
                GeneralLedgerDetail::where('general_ledger_id',$glUpdate->id)->delete();
                $glID = $glUpdate->id;
            }
            $glDetail = JurnalDetail::where('jurnal_id',$this->jurnal_id)->get();
            foreach($glDetail as $detail)
            {
                $transDetail = [
                    'general_ledger_id' => $glID,
                    'account_id' => $detail->account_id,
                    'cost_id' => $detail->cost_id,
                    'debet' => $detail->debet,
                    'credit' => $detail->credit,
                    'memo' => $detail->memo,
                ];
                GeneralLedgerDetail::create($transDetail);
            }
            //End General Ledger
        }
        //PostJurnal::dispatch($jurnal);
        $this->updateMode = 0;

        $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>"Jurnal Transaction Successfull to saved!!"
        ]);
        $this->render();
    }

    public function edit($id)
    {
        $jurnal = Jurnal::findOrFail($id);
        $this->jurnal_id = $id;
        $this->code = $jurnal->code;
        $this->transaction_date = $jurnal->transaction_date;
        $this->description = $jurnal->description;
        $this->allJurnals = JurnalDetail::select(DB::raw('id,account_id,cost_id,debet,credit,memo'))->where('jurnal_id',$id)->get()->toArray();
        //dd($this->allJurnals);
        $this->updateMode = true;
    }

    public function preview($id)
    {
        $jurnal = Jurnal::findOrFail($id);
        $params = [
            'settings' => setSetting(),
            'title'  => 'Jurnal Voucher',
            'jurnal' => $jurnal,
        ];
        $pdf = PDF::loadView('reports.accountings.jurnals.pdf', $params)->output();
        return response()->streamDownload(
            fn () => print($pdf),
            $jurnal->code.'.pdf'
        );
    }

    public function downloadExcel()
    {
        return Excel::download(new JurnalExport($this->filters['start_date'], $this->filters['end_date']),'Journal Transaction List.xlsx');
    }

    public function downloadPDF()
    {
        $results = Jurnal::where([
                        ['jurnals.transaction_date','>=',Carbon::parse($this->filters['start_date'])->format('Y-m-d')],
                        ['jurnals.transaction_date','<=',Carbon::parse($this->filters['end_date'])->format('Y-m-d')]
                    ])
                    ->with('jurnalDetail')
                    ->get();

        $title = 'Daftar Jurnal';
        $params = [
            'settings' => setSetting(),
            'title'  => $title,
            'results' => $results,
            'periodeAwal' => $this->filters['start_date'],
            'periodeAkhir' => $this->filters['end_date'],
        ];
        $pdf = PDF::loadView('reports.accountings.jurnals.list', $params)->output();
        return response()->streamDownload(
            fn () => print($pdf),
            $title.'.pdf'
        );
    }
}
