<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Ledger extends Model
{
    use HasFactory;
    //protected $connection = 'tenant';
    protected $guarded = array();

    //protected $fillable = ['code', 'name', 'type'];
    //protected $hidden = ['address','other_address','phone_no','tax_reg_no','fax_no','bank_account'];

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

    public static function getLedgerByType($type_id)
    {
        return Ledger::where('type_id',$type_id)->get();
    }
}
