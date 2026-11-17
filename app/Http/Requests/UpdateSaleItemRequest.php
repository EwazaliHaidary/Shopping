<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSaleItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
     public function rules(): array
    {
        return [
            "product_id" => "sometimes|exists:products,id",
            "sale_id" => "sometimes|exists:sales,id",
            "quantity" => "sometimes|integer|min:1",
            "unit_price" => "sometimes|numeric|min:0",
        ];
    }

    public function messages(): array
    {
        return [
            "product_id.sometimes" => "انتخاب محصول اجباری است",
            "product_id.exists" => "محصول انتخاب‌شده وجود ندارد",
            "sale_id.sometimes" => "شناسه فروش اجباری است",
            "sale_id.exists" => "فروش موردنظر وجود ندارد",
            "quantity.sometimes" => "تعداد محصول اجباری است",
            "quantity.integer" => "تعداد باید عدد صحیح باشد",
            "quantity.min" => "تعداد باید حداقل یک باشد",
            "unit_price.sometimes" => "قیمت واحد اجباری است",
            "unit_price.numeric" => "قیمت واحد باید عدد باشد",
            "unit_price.min" => "قیمت واحد نمی‌تواند منفی باشد",
        ];
    }
}
