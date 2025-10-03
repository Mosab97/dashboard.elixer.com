<?php

namespace App\Http\Requests\CP;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required|array',
            'description' => 'nullable|array',
            'discount' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'featured' => 'boolean',
            'active' => 'boolean',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',

        ];
        foreach (config('app.locales') as $locale) {
            $rules['name.' . $locale] = 'required|string|max:255';
        }
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
            'name.required' => t('Name is required'),
            'name.array' => t('Name must be provided in multiple languages'),
            'name.*.required' => t('Name is required'),
            'name.*.string' => t('Name must be a string'),
            'name.*.max' => t('Name must not exceed 255 characters'),
            'description.array' => t('Description must be provided in multiple languages'),
            'description.*.string' => t('Description must be a string'),
            'description.*.max' => t('Description must not exceed 255 characters'),
            'discount.numeric' => t('Discount must be a number'),
            'discount.min' => t('Discount must be at least 0'),
            'price.required' => t('Price is required'),
            'price.numeric' => t('Price must be a number'),
            'price.min' => t('Price must be at least 0'),
            'featured.boolean' => t('Featured must be true or false'),
            'active.boolean' => t('Active must be true or false'),
            'quantity.required' => t('Quantity is required'),
            'quantity.integer' => t('Quantity must be a number'),
            'quantity.min' => t('Quantity must be at least 0'),
            'category_id.required' => t('Category is required'),
            'category_id.exists' => t('Category must exist'),

        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'active' => $this->has('active') ? true : false,
            'featured' => $this->has('featured') ? true : false,
        ]);
    }
}
