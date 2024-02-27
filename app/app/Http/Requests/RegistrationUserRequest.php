<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class RegistrationUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|max:255',
            'password' => 'required|string',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $error_mes = $validator->errors()->first();
        throw new HttpResponseException(response($error_mes, Response::HTTP_BAD_REQUEST));
    }
}
