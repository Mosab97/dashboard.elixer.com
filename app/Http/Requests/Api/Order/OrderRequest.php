<?php

namespace App\Http\Requests\Api\Order;

use App\Enums\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'region_id' => 'required|exists:addresses,id',
            'home_address' => 'nullable|string',
            'coupon' => 'nullable|string|exists:coupons,code',
            'payment_method' => ['required', 'string', 'in:' . implode(',', PaymentMethod::toArray())],
            'read_conditions' => 'required|boolean|accepted',
            'item' => 'required|array|min:1',
            'item.*.product_id' => 'required|exists:products,id',
            'item.*.quantity' => 'required|integer|min:1',
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
            'first_name.required' => api('First name is required'),
            'first_name.string' => api('First name must be a string'),
            'first_name.max' => api('First name must not exceed 255 characters'),
            'last_name.required' => api('Last name is required'),
            'last_name.string' => api('Last name must be a string'),
            'last_name.max' => api('Last name must not exceed 255 characters'),
            'phone.required' => api('Phone is required'),
            'phone.string' => api('Phone must be a string'),
            'phone.max' => api('Phone must not exceed 20 characters'),
            'email.required' => api('Email is required'),
            'email.email' => api('Email must be a valid email address'),
            'email.max' => api('Email must not exceed 255 characters'),
            'region_id.required' => api('Region is required'),
            'region_id.exists' => api('Region is invalid'),
            'home_address.string' => api('Home address must be a string'),
            'home_address.max' => api('Home address must not exceed 255 characters'),
            'coupon.string' => api('Coupon must be a string'),
            'coupon.exists' => api('Coupon is invalid'),
            'payment_method.required' => api('Payment method is required'),
            'payment_method.string' => api('Payment method must be a string'),
            'payment_method.in' => api('Payment method is invalid'),
            'read_conditions.required' => api('Read conditions is required'),
            'read_conditions.boolean' => api('Read conditions must be a boolean'),
            'read_conditions.accepted' => api('Read conditions must be accepted'),
            'item.required' => api('Item is required'),
            'item.array' => api('Item must be an array'),
            'item.min' => api('Item must be at least 1'),
            'item.*.product_id.required' => api('Product id is required'),
            'item.*.product_id.exists' => api('Product id is invalid'),
            'item.*.quantity.required' => api('Quantity is required'),
            'item.*.quantity.integer' => api('Quantity must be an integer'),
            'item.*.quantity.min' => api('Quantity must be at least 1'),
        ];
    }
    public function prepareForValidation()
    {
        $this->merge([
            'read_conditions' => $this->has('read_conditions') ? true : false,
        ]);
    }
}
