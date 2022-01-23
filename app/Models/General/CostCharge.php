<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CostCharge extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo('\App\Models\General\Category','category_id','id');
    }

    public function WipAccount()
    {
        return $this->belongsTo('\App\Models\Accounting\Accounts\Account','wip_id','id');
    }

    public function CogsAccount()
    {
        return $this->belongsTo('\App\Models\Accounting\Accounts\Account','cogs_id','id');
    }

    public function ExpenseAccount()
    {
        return $this->belongsTo('\App\Models\Accounting\Accounts\Account','expense_id','id');
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
