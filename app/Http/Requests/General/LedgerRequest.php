<?php

namespace App\Http\Requests\General;

use Illuminate\Foundation\Http\FormRequest;

class LedgerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type'          => 'required',
            'code'          => 'required',
            'name'          => 'required',
            'tax_reg_no'    => 'required',
        ];
    }
}
