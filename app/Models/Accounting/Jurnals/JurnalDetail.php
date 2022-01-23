<?php

namespace App\Models\Accounting\Jurnals;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalDetail extends Model
{
    use HasFactory;
    protected $guarded = array();

    public function account()
    {
        return $this->belongsTo('\App\Models\Accounting\Accounts\Account','account_id','id');
    }

    public function jurnal()
    {
        return $this->belongsTo('\App\Models\Accounting\Jurnals\Jurnal','jurnal_id','id');
    }

    public function ledger()
    {
        return $this->belongsTo('\App\Models\General\Ledger','ledger_id','id');
    }
}
