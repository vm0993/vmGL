<?php

namespace App\Models\GeneralLedgers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class JurnalDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'jurnal_id', 'account_id','debet', 'credit'
    ];

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
