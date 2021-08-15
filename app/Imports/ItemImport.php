<?php

namespace App\Imports;

use App\Models\General\Category;
use App\Models\General\Item;
use App\Models\General\Tax;
use App\Models\General\Unit;
use App\Models\Systems\Setting;
use App\Models\Systems\SettingItemAccount;
use App\Models\Upload;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\BeforeImport;

class ItemImport implements ToModel
{
    private $upload_id;
    
    public function __construct(int $upload_id)
    {
        $this->upload_id = $upload_id;
    }

    public function registerEvents(): array
    {
        return [
            // Handle by a closure.
            BeforeImport::class => function (BeforeImport $event) {
                $total_rows = collect($event->reader->getTotalRows())->flatten()->values();
                $tmp_total_rows = isset($total_rows[0]) ? $total_rows[0] - 1 : 0;
                ray("total rows " . $tmp_total_rows);
                $upload = Upload::find($this->upload_id);
                $upload->status = "in progress";
                $upload->total = $tmp_total_rows;
                $upload->save();
            },
            // Handle by a closure.
            AfterImport::class => function (AfterImport $event) {
                $upload = Upload::find($this->upload_id);
                $upload->status = "finished";
                $upload->save();
            },

        ];
    }

    public function model(array $row)
    {
        $uploadRow = Upload::find($this->upload_id);
        $uploadRow->current = $uploadRow->current > 0 ? $uploadRow->current + 1 : 1;
        $uploadRow->save();

        $setting = Setting::first();
        $itemDefault = SettingItemAccount::where('setting_id',$setting->id)->first();

        $category = Category::where('name',$row[2])->first();
        
        if(in_array($row[3], ['Yes','yes'])){
            $sold = 1;
        }else{
            $sold = 0;
        }
        if(in_array($row[4], ['Yes','yes'])){
            $purchase = 1;
        }else{
            $purchase = 0;
        }
        if(in_array($row[6], ['Yes','yes'])){
            $stock = 1;
        }else{
            $stock = 0;
        }
        $units = Unit::where('code',$row[7])->first();
        $taxs = Tax::where('code',$row[8])->first();
        return new Item([
            'code' => $row[0],
            'name' => $row[1],
            'category_id' => $category->id,
            'sold_id' =>$sold,
            'purchase_item_id' => $purchase,
            'alias_name' => $row[5],
            'stock_id' => $stock,
            'unit_id' => $units->id,
            'tax_id' => $taxs->id,
            'sell_price' => $row[9],
            'buy_price' => $row[10],
        ]);
    }

    public function chunkSize(): int
    {
        return 500; // change your chunk size
    }

    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }
}
