<?php

namespace App\Models\GeneralLedgers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Currency extends Model
{
    use HasFactory;
    protected $fillable = [
        'code', 'name','rate'
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
