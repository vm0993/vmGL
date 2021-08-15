<?php

namespace App\Exports\FinanceStatements;

use Maatwebsite\Excel\Concerns\FromCollection;

class BalanceSheetExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
    }
}
