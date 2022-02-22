<?php

namespace App\Models\Advance;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequestRelease extends Model
{
    use HasFactory;
    //protected $connection = 'tenant';
    protected $guarded = array();

    public static function getReleaseRequestNo($transaction_date)
    {
        $period = Carbon::parse($transaction_date)->format('ym');  
        $lastAccount = RequestRelease::select(DB::raw('max(RIGHT(code, 4)) as result'))
                        ->whereYear('transaction_date',Carbon::parse($transaction_date)->format('Y'))
                        ->whereMonth('transaction_date',Carbon::parse($transaction_date)->format('m'))
                        ->groupByRaw('date_format(transaction_date,"%y%m") = "'.$period.'" ')
                        ->orderBy('id','desc')
                        ->first();
        
        if(!empty($lastAccount)){
            $lastNo = $lastAccount->result + 1;
        }else{
            $lastNo = 1;
        }
        $length_no = 4;
        $tmpNo = sprintf('%0'.$length_no.'s', $lastNo);
        
        return 'RR'.$period.$tmpNo;;
    }

    public function advanced()
    {
        return $this->hasMany('\App\Models\Advance\RequestAdvance','request_advance_id','id');
    }

    public function account()
    {
        return $this->belongsTo('\App\Models\Accounting\Accounts\Account','account_id','id');
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
