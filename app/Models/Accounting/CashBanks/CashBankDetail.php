<?php

namespace App\Models\Accounting\CashBanks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashBankDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function cashBank()
    {
        return $this->belongsTo('\App\Models\Accounting\CashBanks\CashBank','cash_bank_id','id');
    }
}
