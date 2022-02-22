<?php

namespace App\Http\Requests\Advance;

use Illuminate\Foundation\Http\FormRequest;

class ReleaseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'request_advance_id' => 'required',
            'account_id'         => 'required',
            'transaction_date'   => 'required',
        ];
    }
}
