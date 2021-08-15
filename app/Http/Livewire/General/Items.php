<?php

namespace App\Http\Livewire\General;

use App\Exports\General\ItemExport;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Imports\ItemImport;
use App\Models\General\Category;
use App\Models\General\Item;
use App\Models\General\Tax;
use App\Models\General\Unit;
use App\Models\Systems\Setting;
use App\Models\Systems\SettingItemAccount;
use App\Models\Upload;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class Items extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows, WithFileUploads;

    public $category_id, $code, $name, $alias_name, $stock_id, $unit_id, $tax_id, $sell_price, $buy_price, $inventory_id;
    public $sales_id ,$return_id, $discount_id, $delivery_id, $cogs_id, $purchase_id, $return_buy_id,$expense_id, $item_id;
    public $sold_id, $purchase_item_id;
    
    public $excelFile;
    public $fileName;
    public $isUploaded = false;
    public $showUpload = false;
    public $currentStep = 1;
    public $updateMode = 0;
    public $showDeleteModal = false;
    public $confirmingDeletion = false;
    public $showEditModal = false;
    public $showEditForm = false;
    public $showFilters = false;
    public Item $editing;
    protected $queryString = ['sorts'];
    public $filters = [
        'search' => '',
        'code' => '',
        'name' => '',
    ];

    protected $listeners = ['refreshTransactions' => '$refresh'];

    public function rules() { 
        return [
            'category_id' => 'required',
            'code' => 'required|min:3',
            'name' => 'required',
            'alias_name' => 'nullable',
            'stock_id' => 'nullable',
            'sold_id' => 'nullable',
            'purchase_item_id' => 'nullable',
            'unit_id' => 'required',
            'tax_id' => 'required',
            'sell_price' => 'nullable',
            'buy_price' => 'nullable',
            'inventory_id' => 'nullable',
            'sales_id' => 'nullable',
            'return_id' => 'nullable',
            'discount_id' => 'nullable',
            'delivery_id' => 'nullable',
            'cogs_id' => 'nullable',
            'purchase_id' => 'nullable',
            'return_buy_id' => 'nullable',
            'expense_id' => 'nullable',
        ]; 
    }

    public function mount() { $this->editing = $this->makeBlankTransaction(); }

    public function updatedFilters() { $this->resetPage(); }

    public function resetFilters() { $this->reset('filters'); }

    public function toggleShowFilters()
    {
        $this->useCachedRows();

        $this->showFilters = ! $this->showFilters;
    }

    public function makeBlankTransaction()
    {
        return Item::make(
            [
                'category_id' => 0,
                'unit_id' => 0,
                'tax_id' => 0,
                'stock_id' => 0,
                'sold_id' => 0,
                'purchase_item_id' => 0,
                'status' => 0,
                'inventory_id' => 0,
                'sales_id' => 0,
                'return_id' => 0,
                'discount_id' => 0,
                'delivery_id' => 0,
                'cogs_id' => 0,
                'purchase_id' => 0,
                'return_buy_id' => 0,
                'expense_id' => 0,
            ]);
    }

    public function getRowsQueryProperty()
    {
        $results = Item::select(DB::raw('items.id,items.code,items.name,categories.name as catname,items.alias_name,units.code as unitcode,
                    case when items.stock_id=1 then "Stockable" else "Non Inventory" end as invotorys,items.sell_price,items.buy_price,taxes.code as taxcode,items.status'))
                    ->join('categories','categories.id','=','items.category_id')
                    ->join('units','units.id','=','items.unit_id')
                    ->join('taxes','taxes.id','=','items.tax_id');

        $query = $results
            ->when($this->filters['code'], fn($query, $code) => $query->where('items.code', 'like', '%'.$code.'%'))
            ->when($this->filters['name'], fn($query, $name) => $query->where('items.name', 'like', '%'.$name.'%'))
            ->when($this->filters['search'], fn($query, $search) => $query->where('items.name', 'like', '%'.$search.'%'));

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
        return view('livewire.general.items', [
            'items' => $this->rows, 
            'categorys' => Category::select(DB::raw('id,concat(code," - ", name) as name'))->get(),
            'units' => Unit::select(DB::raw('id,concat(code," - ",name) as name '))->get(),
            'taxs' => Tax::select(DB::raw('id,concat(code," - ",name) as name '))->get(),
            $this->updateMode = 0,
        ]);
    }

    public function create()
    {
        $this->useCachedRows();

        if($this->editing->getKey()) $this->editing = $this->makeBlankTransaction();
        $this->item_id = '';
        $this->resetField();
        $setting = Setting::first();
        $itemDefault = SettingItemAccount::where('setting_id',$setting->id)->first();
        if($itemDefault){
            $this->inventory_id = $itemDefault->inventory_id;
            $this->sales_id = $itemDefault->sales_id;
            $this->return_id = $itemDefault->return_id;
            $this->discount_id = $itemDefault->discount_id;
            $this->delivery_id = $itemDefault->delivery_id;
            $this->cogs_id = $itemDefault->cogs_id;
            $this->purchase_id = $itemDefault->purchase_id;
            $this->return_buy_id = $itemDefault->return_buy_id;
        }
        $this->showEditForm = true;
        $this->showEditModal = true;
    }

    public function save()
    {
        $this->validate();
        try {
            //code...
            $data = [
                'code' => $this->code,
                'name' => $this->name,
                'category_id' => $this->category_id,
                'sold_id' => $this->sold_id,
                'purchase_item_id' => $this->purchase_item_id,
                'alias_name' => $this->alias_name,
                'stock_id' => $this->stock_id,
                'unit_id' => $this->unit_id,
                'tax_id' => $this->tax_id,
                'sell_price' => $this->sell_price,
                'buy_price' => $this->buy_price,
            ];
            //dd($data);
            if($this->item_id == null){
                Item::create($data);
            }else{
                $item = Item::find($this->item_id);
                $item->update($data);
            }
            //$this->editing->save();
            $this->showEditModal = false;

            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Item Created Successfully!!"
            ]);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"Something goes wrong while creating item!"
            ]);
        }
    }

    public function edit(Item $item)
    {
        $this->item_id = $item->id;
        $this->name = $item->name;
        $this->alias_name = $item->alias_name;
        $this->category_id = $item->category_id;
        $this->sold_id = $item->sold_id;
        $this->purchase_id = $item->purchase_id;
        $this->tax_id = $item->tax_id;
        $this->unit_id = $item->unit_id;
        $this->sell_price = $item->sell_price;
        $this->buy_price = $item->buy_price;
        $setting = Setting::first();
        /* $itemDefault = SettingItemAccount::where('setting_id',$setting->id)->first();
        if($itemDefault){
            $this->inventory_id = $itemDefault->inventory_id;
            $this->sales_id = $itemDefault->sales_id;
            $this->return_id = $itemDefault->return_id;
            $this->discount_id = $itemDefault->discount_id;
            $this->delivery_id = $itemDefault->delivery_id;
            $this->cogs_id = $itemDefault->cogs_id;
            $this->purchase_id = $itemDefault->purchase_id;
            $this->return_buy_id = $itemDefault->return_buy_id;
        } */
        $this->showEditModal = true;
        //$this->updateMode = 2;
    }

    public function closeModal()
    {
        $this->showEditModal = false;
    }
    
    public function delete(Item $item)
    {
        $item->delete();
        $this->confirmingDeletion = false;
        session()->flash('message', 'Item Deleted Successfully');
    }

    public function confirmingDeletion($id) 
    {
        $this->confirmingDeletion = $id;
    }

    public function importItem()
    {
        $this->showUpload = true;
    }

    public function closeImport()
    {
        $this->showUpload = false;
    }

    public function storeImport()
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

        $import = new ItemImport($upload->id);
        Excel::import($import, $path);

        $this->isUploaded = true;
        $this->showUpload = false;
        $this->fileName = '';
    }

    public function downloadExcel()
    {
        return Excel::download(new ItemExport,'Item List.xlsx');
    }

    public function downloadPDF()
    {
        $results = Item::with(['category','unit','tax'])->get();
        $title = 'Daftar Barang & Jasa';
        $params = [
            'settings' => setSetting(),
            'title'  => $title,
            'results' => $results,
        ];
        $pdf = PDF::loadView('reports.generals.items.pdf', $params)->output();
        return response()->streamDownload(
            fn () => print($pdf),
            $title.'.pdf'
        );
    }

    public function resetField()
    {
        $this->code = '';
        $this->item_id = '';
        $this->name = '';
        $this->alias_name = '';
        $this->sell_price = 0;
        $this->buy_price = 0;
        $this->category_id = 0;
        $this->unit_id = 0;
        $this->tax_id = 0;
        $this->sold_id = 0;
        $this->purchase_id = 0;
        $this->stock_id = 0;
    }
}
