<?php

namespace App\Http\Requests\CP;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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
        $id = $this->input(config('modules.products.id_field'));

        $isUpdate = ! empty($id);

        $rules = [
            'name' => 'required|array',
            'slug' => [
                'required',
                'string',
                $isUpdate ? Rule::unique('products')->ignore($id) : Rule::unique('products')
            ],
            'description' => 'nullable|array',
            'how_to_use' => 'nullable|array',
            'details' => 'nullable|array',
            'discount' => 'nullable|numeric|min:0',
            'price_after_discount' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'featured' => 'boolean',
            'active' => 'boolean',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'rate_count' => 'required|integer|min:0',
        ];
        foreach (config('app.locales') as $locale) {
            $rules['name.' . $locale] = 'required|string|max:255';
            $rules['description.' . $locale] = 'nullable|string|max:20000';
            $rules['how_to_use.' . $locale] = 'nullable|string|max:20000';
            $rules['details.' . $locale] = 'nullable|string|max:20000';
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

            'slug.required' => t('Slug is required'),
            'slug.string' => t('Slug must be a string'),
            'slug.unique' => t('Slug must be unique'),

            'description.array' => t('Description must be provided in multiple languages'),
            'description.*.string' => t('Description must be a string'),
            'description.*.max' => t('Description must not exceed 20000 characters'),
            'discount.numeric' => t('Discount must be a number'),
            'discount.min' => t('Discount must be at least 0'),

            'how_to_use.array' => t('How to Use must be provided in multiple languages'),
            'how_to_use.*.string' => t('How to Use must be a string'),
            'how_to_use.*.max' => t('How to Use must not exceed 20000 characters'),
            'details.array' => t('Details must be provided in multiple languages'),
            'details.*.string' => t('Details must be a string'),
            'details.*.max' => t('Details must not exceed 20000 characters'),


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
        $price = (float)$this->price ?? 0;
        $discount = (float)$this->discount ?? 0;
        $price_after_discount = $price - ($price * $discount / 100);
        $this->merge([
            'active' => $this->has('active') ? true : false,
            'featured' => $this->has('featured') ? true : false,
            'price_after_discount' => $price_after_discount,
            'slug' => Str::slug($this->name['en']),
        ]);
        // dd($this->all(), $this->price - ($this->price * $this->discount));
    }
}
