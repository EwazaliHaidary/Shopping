<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
        "category_id" => "sometimes|exists:categories,id",
        "name" => "sometimes|string|max:255",
        "sku" => "sometimes|unique:products,sku,".$this->route("product"),
        "description" =>"sometimes|nullable|string",
        "purchase_price" => "sometimes|numeric|min:0",
        "sale_price"=> "sometimes|numeric|min:0",
        "stock" => "sometimes|integer|min:0",
        "alert_quantity" => "sometimes|integer|min:0",
        "is_active" => "sometimes|boolean"
        ]; 
    }


    public function messages(): array
    {
    return [
        "category_id.exists" => "کتگوری انتخاب‌شده در دیتابیس وجود ندارد",

        "name.string" => "نام محصول باید متن باشد",
        "name.max" => "نام محصول نباید بیشتر از ۲۵۵ حرف باشد",

        "sku.string" => "SKU باید متن باشد",
        "sku.unique" => "این SKU قبلاً برای محصول دیگری ثبت شده است",

        "description.string" => "توضیحات باید به شکل متن باشد",

        "purchase_price.numeric" => "قیمت خرید باید عدد باشد",
        "purchase_price.min" => "قیمت خرید نمی‌تواند منفی باشد",

        "sale_price.numeric" => "قیمت فروش باید عدد باشد",
        "sale_price.min" => "قیمت فروش نمی‌تواند منفی باشد",

        "stock.integer" => "موجودی باید عدد صحیح باشد",
        "stock.min" => "موجودی نمی‌تواند منفی باشد",

        "alert_quantity.integer" => "مقدار هشدار باید عدد صحیح باشد",
        "alert_quantity.min" => "مقدار هشدار نمی‌تواند منفی باشد",

        "is_active.boolean" => "وضعیت محصول باید فعال یا غیرفعال باشد",
    ];
}
}
