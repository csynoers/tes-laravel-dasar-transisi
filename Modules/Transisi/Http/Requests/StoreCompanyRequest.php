<?php

namespace Modules\Transisi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class StoreCompanyRequest extends FormRequest
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
            'email' => 'email|required|unique:companies',
            'website' => 'required|url|unique:companies',
            'logo_company' => 'required|image|file|mimes:png|dimensions:min_width=100,min_height=100|max:2048'
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
