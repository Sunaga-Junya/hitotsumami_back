<?php

namespace App\Http\Requests;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Log;

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
        Log::debug($validator->errors()->toArray());
        throw new HttpResponseException(response(null,400));
    }
}

