<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        "category_id" => "required|exists:categories,id",
        "name" => "required|string|max:255",
        "sku" => "required|unique:products,sku",
        "description" =>"nullable|string",
        "purchase_price" => "required|numeric|min:0",
        "sale_price"=> "required|numeric|min:0",
        "stock" => "required|integer|min:0",
        "alert_quantity" => "required|integer|min:0",
        "is_active" => "required|boolean"
        ];
    }
    public function messages(): array{
        return[
        "category_id.required" => "انتخاب کتگوری اجباری است",
        "category_id.exists" => "یک کتگوری باید انتخاب شود",
        "name.required" => "نام اجباری است",
        "sku.required"=> "این قسمت اجباری است",
        "sku.unique" => "این sku قبلا در دیتابیس ثبت شده است",
        
        ];
    }
}
