<?php

namespace App\Helpers;

use App\Models\General\Category;
use App\Models\General\Item;
use App\Models\General\Ledger;
use App\Models\General\Tax;
use App\Models\General\Unit;
use Illuminate\Support\Facades\DB;

class GeneralHelper
{

    public static function setCompanyType()
    {
        $companyType = [
            0 => 'Jasa Umum',
            1 => 'Kontraktor',
            2 => 'Pelayaran/EMKL',
            3 => 'Manufaktur',
        ];

        return $companyType;
    }

    public static function getCategory()
    {
        $categorys = Category::select(DB::raw('id,concat(code," - ",name) as name'))
                    ->where('status',0)
                    ->get();

        return $categorys;
    }

    public static function getTaxes()
    {
        $taxs = Tax::select(DB::raw('id,concat(code," - ",name) as name'))
                    ->where('status',0)
                    ->get();

        return $taxs;
    }

    public static function getUnit()
    {
        $units = Unit::select(DB::raw('id,concat(code," - ",name) as name'))
                    ->where('status',0)
                    ->get();

        return $units;
    }

    public static function getItem()
    {
        $items = Item::select(DB::raw('id,concat(code," - ",name) as name'))
                    ->where('status',0)
                    ->get();

        return $items;
    }

    public static function getLedgerType()
    {
        $ledgerType = array(
            0 => trans('ledger.customer_id'),
            1 => trans('ledger.vendor_id'),
            2 => trans('ledger.both_id'),
        );

        return $ledgerType;
    }
}