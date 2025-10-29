<?php

namespace App\Http\Requests\CP;

use Illuminate\Foundation\Http\FormRequest;

class HowWeWorkRequest extends FormRequest
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
            'title' => 'required|array',
            'description' => 'nullable|array',
            'active' => 'boolean',
            'order' => 'nullable|integer|min:0',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'delete_icon' => 'nullable|boolean',
        ];

        foreach (config('app.locales') as $locale) {
            $rules['title.' . $locale] = 'required|string|max:255';
            $rules['description.' . $locale] = 'nullable|string|max:255';
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
            'title.required' => t('How We Work title is required'),
            'title.array' => t('How We Work title must be provided in multiple languages'),
            'title.*.required' => t('Title is required'),
            'title.*.string' => t('Each title field must be a string'),
            'title.*.max' => t('Each title field must not exceed 255 characters'),
            'description.array' => t('How We Work description must be provided'),
            'description.*.required' => t('Each description field is required'),
            'description.*.string' => t('Each description field must be a string'),
            'description.*.max' => t('Each description field must not exceed 255 characters'),
            'active.boolean' => t('Active status must be true or false'),
            'order.integer' => t('Order field must be an integer'),
            'order.min' => t('Order field must be at least 0'),
            'icon.image' => t('Icon must be an image file'),
            'icon.mimes' => t('Icon must be a file of type: jpeg, png, jpg, gif, svg, webp'),
            'icon.max' => t('Icon file size must not exceed 2MB'),
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'active' => $this->has('active') ? true : false,
            // 'delete_icon' => $this->has('delete_icon') ? true : false,
        ]);
    }
}
