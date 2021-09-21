<?php

namespace App\Models\Accounting\Currencys;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Currency extends Model
{
    use HasFactory;
    protected $guarded = [];

    const STATUSES = [
        'active' => "{{ __('global.active') }}",
        'suspend' => "{{ __('global.non_active') }}",
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
