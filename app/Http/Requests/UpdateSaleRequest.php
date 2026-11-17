<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "customer_id" => "sometimes|exists:customers,id",
            "discount" => "sometimes|numeric|min:0",
            "notes" => "sometimes|nullable|string",
            "items" => "sometimes|array|min:1",
            "items.*.product_id" => "required_with:items|exists:products,id",
            "items.*.quantity" => "required_with:items|integer|min:1",
        ];
    }

    public function messages(): array
    {
        return [
            "customer_id.exists" => "مشتری انتخاب‌شده وجود ندارد",
            "discount.numeric" => "تخفیف باید عدد باشد",
            "discount.min" => "تخفیف نمی‌تواند منفی باشد",
            "items.array" => "ساختار محصولات درست نیست",
            "items.min" => "حداقل یک محصول باید ثبت شود",
            "items.*.product_id.required_with" => "انتخاب محصول اجباری است",
            "items.*.product_id.exists" => "محصول انتخاب‌شده وجود ندارد",
            "items.*.quantity.required_with" => "تعداد محصول اجباری است",
            "items.*.quantity.integer" => "تعداد باید عدد صحیح باشد",
            "items.*.quantity.min" => "تعداد باید حداقل یک باشد",
        ];
    }
}
