<?php

namespace App\Http\Requests\General;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'category_id'   => 'required',
            'code'          => 'required',
            'name'          => 'required',
            'unit_id'       => 'required',
            'buy_tax_id'    => 'required',
            'sell_tax_id'   => 'required',
        ];
    }
}
