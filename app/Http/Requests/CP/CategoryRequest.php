<?php

namespace App\Http\Requests\CP;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'active' => 'boolean',
            'order' => 'nullable|integer|min:0',
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
            'name.required' => t('Category name is required'),
            'name.array' => t('Category name must be provided in multiple languages'),
            'name.*.required' => t('Name is required'),
            'name.*.string' => t('Name must be a string'),
            'name.*.string' => t('Name must be a string'),
            'name.*.max' => t('Category name must not exceed 255 characters'),

            'image.image' => t('Image must be an image file'),
            'image.mimes' => t('Image must be a file of type: jpeg, png, jpg, gif, svg'),
            'image.max' => t('Image file size must not exceed 2MB'),

            'icon.image' => t('Icon must be an image file'),
            'icon.mimes' => t('Icon must be a file of type: jpeg, png, jpg, gif, svg'),
            'icon.max' => t('Icon file size must not exceed 1MB'),

            'active.boolean' => t('Active status must be true or false'),

            'order.integer' => t('Order must be a number'),
            'order.min' => t('Order must be at least 0'),

        ];
    }
    public function prepareForValidation()
    {
        $this->merge([
            'active' => $this->has('active') ? true : false,
        ]);
    }
}
