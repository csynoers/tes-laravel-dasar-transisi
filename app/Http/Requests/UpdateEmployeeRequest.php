<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
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
            'name' => 'required',
            'company' => [
                'required',
                Rule::unique('employees')->ignore($this->employee)    
            ],
            'email' => [
                'email',
                'required',
                Rule::unique('employees')->ignore($this->employee)    
            ],
            'status' => 'required'
        ];
    }
}
