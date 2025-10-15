<?php

namespace App\Http\Requests\CP;

use Illuminate\Foundation\Http\FormRequest;

class RealResultRequest extends FormRequest
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
            'description' => 'required|array',
            'image_before' => 'nullable|image|mimes:'.implode(',', config('app.image_mimes')).'|max:2048',
            'image_after' => 'nullable|image|mimes:'.implode(',', config('app.image_mimes')).'|max:1024',
            'delete_image_before' => 'nullable|boolean',
            'delete_image_after' => 'nullable|boolean',
            'active' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ];
        foreach (config('app.locales') as $locale) {
            $rules['name.' . $locale] = 'required|string|max:255';
            $rules['description.' . $locale] = 'required|string|max:255';
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
            'description.required' => t('Category description is required'),
            'description.array' => t('Category description must be provided in multiple languages'),
            'name.*.required' => t('Name is required'),
            'name.*.string' => t('Name must be a string'),
            'description.*.required' => t('Description is required'),
            'description.*.string' => t('Description must be a string'),
            'description.*.string' => t('Description must be a string'),
            'name.*.max' => t('Category name must not exceed 255 characters'),

            'image_before.image' => t('Image before must be an image file'),
            'image_before.mimes' => t('Image must be a file of type: :mimes',['mimes' => implode(',', config('app.image_mimes'))]),
            'image_before.max' => t('Image file size must not exceed :max',['max' => 2048]),

            'image_after.image' => t('Image after must be an image file'),
            'image_after.mimes' => t('Icon must be a file of type: :mimes',['mimes' => implode(',', config('app.image_mimes'))]),
            'image_after.max' => t('Icon file size must not exceed :max',['max' => 1024]),

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
