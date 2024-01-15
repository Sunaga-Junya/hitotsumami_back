<?php

namespace App\Http\Requests;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
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
        Log::debug($validator->errors()->toArray());
        throw new HttpResponseException(response(null,400));
    }
}
