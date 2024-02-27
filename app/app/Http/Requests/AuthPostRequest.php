<?php

namespace App\Http\Requests;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class AuthPostRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email'=> 'required|string|max:255',
            'password'=> 'required|string' 
        ];
    }
    protected function failedValidation(Validator $validator): void
    {
        $error_mes = $validator->errors()->first();
        throw new HttpResponseException(response($error_mes,Response::HTTP_BAD_REQUEST));
    }
}
