<?php

namespace App\Models\Accounting\CashBanks;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CashBank extends Model
{
    use HasFactory;
    //protected $connection = 'tenant';
    
    protected $guarded = array();

    const STATUSES = [
        'post' => "{{ __('global.post') }}",
        'suspend' => "{{ __('global.non_active') }}",
    ];

    public function account()
    {
        return $this->belongsTo('\App\Models\Accounting\Accounts\Account','account_id','id');
    }

    public function cashBankDetail()
    {
        return $this->hasMany('\App\Models\Accounting\CashBanks\CashBankDetail','cash_bank_id','id');
    }

    public static function getCashBankNo($transaction_date, $tipe_id)
    {
        $period = Carbon::parse($transaction_date)->format('ym');  
        $lastAccount = CashBank::select(DB::raw('max(RIGHT(code, 4)) as result'))
                    ->whereYear('transaction_date',Carbon::parse($transaction_date)->format('Y'))
                    ->whereMonth('transaction_date',Carbon::parse($transaction_date)->format('m'))
                    ->where('transaction_id',$tipe_id)
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
        if($tipe_id == 0){
            return 'CBO'.Carbon::parse($transaction_date)->format('ym').$tmpNo;
        }else{
            return 'CBI'.Carbon::parse($transaction_date)->format('ym').$tmpNo;
        }
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
