<?php

namespace App\Http\Requests\General;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
            'categori_id'   => 'required',
            'code'          => 'required',
            'name'          => 'required',
            'type_id'       => 'required',
        ];
    }
}
