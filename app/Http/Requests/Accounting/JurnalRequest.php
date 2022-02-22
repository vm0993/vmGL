<?php

namespace App\Http\Requests\Accounting;

use Illuminate\Foundation\Http\FormRequest;

class JurnalRequest extends FormRequest
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
     *  'products' => 'required|array',
        'quantities' => 'required|array',
        'prices' => 'required|array',
     * @return array
     */
    public function rules()
    {
        return [
            'voucher_no'       => 'required',
            'transaction_date' => 'required',
            'account_id_*'     => 'required|array',
            'debet_*'          => 'required|array',
            'credit_*'         => 'required|array',
        ];
    }
}
