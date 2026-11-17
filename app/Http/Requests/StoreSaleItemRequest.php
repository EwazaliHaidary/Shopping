<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSaleItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "product_id" => "required|exists:products,id",
            "sale_id" => "required|exists:sales,id",
            "quantity" => "required|integer|min:1",
            "unit_price" => "required|numeric|min:0",
        ];
    }

    public function messages(): array
    {
        return [
            "product_id.required" => "انتخاب محصول اجباری است",
            "product_id.exists" => "محصول انتخاب‌شده وجود ندارد",
            "sale_id.required" => "شناسه فروش اجباری است",
            "sale_id.exists" => "فروش موردنظر وجود ندارد",

            "quantity.required" => "تعداد محصول اجباری است",
            "quantity.integer" => "تعداد باید عدد صحیح باشد",
            "quantity.min" => "تعداد باید حداقل یک باشد",

            "unit_price.required" => "قیمت واحد اجباری است",
            "unit_price.numeric" => "قیمت واحد باید عدد باشد",
            "unit_price.min" => "قیمت واحد نمی‌تواند منفی باشد",
        ];
    }
}
