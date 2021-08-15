<?php

namespace App\Exports\FinanceStatements;

use Maatwebsite\Excel\Concerns\FromCollection;

class GeneralLedgerExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
    }
}
