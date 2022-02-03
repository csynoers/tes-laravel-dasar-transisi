<?php

namespace Modules\Transisi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateEmployeeRequest extends FormRequest
{
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
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $errors = (new ValidationException($validator))->errors();
        
        if ( !empty($errors)) {
            # code...
            throw new HttpResponseException(
                response()->json([
                    'status' =>  JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                    'error' => $errors
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            );
        }
    }
}
