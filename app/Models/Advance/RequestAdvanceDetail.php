<?php

namespace App\Models\Advance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestAdvanceDetail extends Model
{
    use HasFactory;
    
    //protected $connection = 'tenant';
    protected $guarded = [];

    public function advanceHeader()
    {
        return $this->belongsTo('\App\Models\Advance\RequestAdvance','request_advance_id','id');
    }

    public function jobOrder()
    {
        return $this->belongsTo('\App\Models\Jobs\JobOrder','job_order_id','id');
    }
}
