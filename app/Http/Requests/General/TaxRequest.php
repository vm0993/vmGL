<?php

namespace App\Http\Requests\General;

use Illuminate\Foundation\Http\FormRequest;

class TaxRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'code'                => 'required',
            'name'                => 'required',
            'rate'                => 'required',
            'purchase_account_id' => 'required',
            'sales_account_id'    => 'required',
        ];
    }
}
