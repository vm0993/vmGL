<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Tax extends Model
{
    use HasFactory;
    //protected $connection = 'tenant';

    protected $guarded = array();

    public  function purchaseAccount()
    {
        return $this->belongsTo('\App\Models\Accounting\Accounts\Account','purchase_account_id','id');
    }

    public function salesAccount()
    {
        return $this->belongsTo('\App\Models\Accounting\Accounts\Account','sales_account_id','id');
    }

    public function user()
    {
        return $this->belongsTo('\App\Models\User','created_by','id');
    }
    
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_by = Auth::id();
        });
        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });
    }
}
