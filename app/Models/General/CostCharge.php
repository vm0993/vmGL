<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CostCharge extends Model
{
    use HasFactory;
    //protected $connection = 'tenant';

    protected $guarded = array();

    public function category()
    {
        return $this->belongsTo('\App\Models\General\Category','categori_id','id');
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

    public function user()
    {
        return $this->belongsTo('\App\Models\User','created_by','id');
    }
    
    public static function getServicesByType($type)
    {
        $charges = CostCharge::select(DB::raw('cost_charges.id,cost_charges.categori_id,categories.name,cost_charges.code,cost_charges.name as chargename'))
                    ->join('categories','categories.id','=','cost_charges.categori_id')
                    ->where([
                        ['cost_charges.type_id',$type],
                        ['cost_charges.status',0]
                    ])
                    ->get();

        return $charges;
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
