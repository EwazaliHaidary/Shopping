<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "customer_id" => "required|exists:customers,id",
            "discount" => "nullable|numeric|min:0",
            "notes" => "nullable|string",
            "items" => "required|array|min:1",
            "items.*.product_id" => "required|exists:products,id",
            "items.*.quantity" => "required|integer|min:1",
        ];
    }

    public function messages(): array
    {
        return [
            "customer_id.required" => "انتخاب مشتری اجباری است",
            "customer_id.exists" => "مشتری انتخاب‌شده وجود ندارد",

            "discount.numeric" => "تخفیف باید عدد باشد",
            "discount.min" => "تخفیف نمی‌تواند منفی باشد",

            "items.required" => "حداقل یک محصول باید انتخاب شود",
            "items.array" => "ساختار محصولات درست نیست",
            "items.min" => "حداقل یک محصول باید ثبت شود",

            "items.*.product_id.required" => "انتخاب محصول اجباری است",
            "items.*.product_id.exists" => "محصول انتخاب‌شده وجود ندارد",

            "items.*.quantity.required" => "تعداد محصول اجباری است",
            "items.*.quantity.integer" => "تعداد باید عدد صحیح باشد",
            "items.*.quantity.min" => "تعداد باید حداقل یک باشد",
        ];
    }
}
