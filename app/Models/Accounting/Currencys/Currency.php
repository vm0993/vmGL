<?php

namespace App\Models\Accounting\Currencys;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Currency extends Model
{
    use HasFactory;
    //protected $connection = 'tenant';
    protected $guarded = array();

    public function user()
    {
        return $this->belongsTo('\App\Models\User','created_by','id');
    }

    public function getCodeAttribute($value)
    {
        return ucfirst($value);
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function getCodeFullAttribute()
    {
        return ucfirst($this->code) . " : " . ucfirst($this->name);
    }

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = ucfirst($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
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
