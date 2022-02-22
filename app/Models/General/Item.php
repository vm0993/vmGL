<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Item extends Model
{
    use HasFactory;
    //protected $connection = 'tenant';
    
    protected $guarded = array();

    public function user()
    {
        return $this->belongsTo('\App\Models\User','created_by','id');
    }

    public function category()
    {
        return $this->belongsTo('\App\Models\General\Category','category_id','id');
    }

    public function unit()
    {
        return $this->belongsTo('\App\Models\General\Unit','unit_id','id');
    }

    public function buyTax()
    {
        return $this->belongsTo('\App\Models\General\Tax','buy_tax_id','id');
    }

    public function sellTax()
    {
        return $this->belongsTo('\App\Models\General\Tax','sell_tax_id','id');
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
