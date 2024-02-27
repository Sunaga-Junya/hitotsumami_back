<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class PostRecipeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'description' => 'required|string',
            'time_required_min' => 'required|integer',
            'ingredients' => 'required|array|min:1',
            'seasonings' => 'nullable|array',
            'steps' => 'required|array|min:1',
            'image_path' => 'nullable|string',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $error_msg = $validator->errors()->first();
        throw new HttpResponseException(response($error_msg,Response::HTTP_BAD_REQUEST));
    }
}

