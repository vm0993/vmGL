<?php

namespace App\Models\Accounting\Currencys;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyDefault extends Model
{
    use HasFactory;

    //protected $connection = 'tenant';
    protected $guarded = array();

    public function currency()
    {
        return $this->belongsTo('\App\Models\Accounting\Currencys\Currency','currency_id','id');
    }
}
