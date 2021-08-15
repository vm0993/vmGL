<?php

namespace App\Imports;

use App\Helpers\FinanceHelper;
use App\Models\Accounting\Account;
use App\Models\Upload;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\BeforeImport;

class AccountImport implements ToModel
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

        $tipeAkun = FinanceHelper::getAccountType();
        foreach($tipeAkun as $tipe => $a){
            if($row[2] == $a){
                $tipeID = $tipe;
            }
        }
        $groupAccountId = Account::where('account_no',$row[3])->get()->first();
        if($groupAccountId != ''){
            $groupId = $groupAccountId->id;
        }else{
            $groupId =0;
        }
        return new Account([
            'account_no' => $row[0],
            'account_name' => $row[1],
            'account_type' => $tipeID,
            'group_account_id' => $groupId,
            'is_jurnal' => $row[4]=='No' ? 1 : 0,
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
