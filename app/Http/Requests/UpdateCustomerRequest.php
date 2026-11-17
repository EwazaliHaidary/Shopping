<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
        "name" => "sometimes|string",
        "email"=> "sometimes|email|unique:customers,email,".$this->route("customer"),
        "phone" => "string|nullable|max:10",
        "address" => "string|nullable"
        ];
    }
    public function messages(): array{
        return [
            "name.string"=> "نام غیر از حروف بوده نمیتواند",
            "email.email" => "باید فرمت ایمیل را داشته باشد",
            "email.unique" => "این ایمیل قبلا در دیتابیس ثبت شه است",
            "phone.string" => "شماره تماس باید نمبر باشد",
            "phone.max" => "شماره تماس از ۱۰ رقم بیشتر بوده نمیتواند",
            "address.string" => "آدرس غیر از حروف بوده نمبتواند"
        ];
    }
}
