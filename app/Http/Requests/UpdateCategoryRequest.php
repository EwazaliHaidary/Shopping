<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
 
    public function rules(): array
    {
        return [
        "name" => "sometimes|string|max:255|unique:categories,name," . $this->route('category'),
        "description" => "sometimes|nullable|string"
    ];
    }
}
