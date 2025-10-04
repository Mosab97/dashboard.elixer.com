<?php

namespace App\Http\Requests\CP;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'code' => 'required|string|max:255',
            'discount' => 'required|numeric|min:0',
            'expiry_date' => 'required|date',
            'active' => 'boolean',
        ];
        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'code.required' => t('Coupon code is required'),
            'code.string' => t('Coupon code must be a string'),
            'code.max' => t('Coupon code must not exceed 255 characters'),
            'discount.required' => t('Coupon discount is required'),
            'discount.numeric' => t('Coupon discount must be a number'),
            'discount.min' => t('Coupon discount must be at least 0'),
            'expiry_date.required' => t('Coupon expiry date is required'),
            'expiry_date.date' => t('Coupon expiry date must be a date'),
            'active.boolean' => t('Active status must be true or false'),
        ];
    }
    public function prepareForValidation()
    {
        $this->merge([
            'active' => $this->has('active') ? true : false,
        ]);
    }
}
