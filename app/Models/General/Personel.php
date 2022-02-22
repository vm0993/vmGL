<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Personel extends Model
{
    use HasFactory;
    //protected $connection = 'tenant';
    protected $guarded = array();

    const LEDGER_TYPE = [
        'CUSTOMER'  => 'Customer',
        'VENDOR'    => 'Vendor',
        'BOTH'      => 'Keduanya',
    ];

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
