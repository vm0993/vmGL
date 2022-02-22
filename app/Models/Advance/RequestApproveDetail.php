<?php

namespace App\Models\Advance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestApproveDetail extends Model
{
    use HasFactory;
    //protected $connection = 'tenant';
    protected $guarded = [];

    public function approvalHeader()
    {
        return $this->belongsTo('\App\Models\Advance\RequestApprove','request_approve_id','id');
    }
}
