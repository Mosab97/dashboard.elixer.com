<?php

namespace App\Http\Requests\CP;

use Illuminate\Foundation\Http\FormRequest;

class WhyChooseUsRequest extends FormRequest
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'active' => 'boolean',
            'order' => 'nullable|integer|min:0',
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
            'title.required' => t('Slider title is required'),
            'title.array' => t('Slider title must be provided in multiple languages'),
            'title.*.required' => t('Title is required'),
            'title.*.string' => t('Each title field must be a string'),
            'title.*.max' => t('Each title field must not exceed 255 characters'),
            'description.array' => t('Description must be provided in multiple languages'),
            'description.*.required' => t('Each description field is required'),
            'description.*.string' => t('Each description field must be a string'),
            'description.*.max' => t('Each description field must not exceed 255 characters'),
            'title.*.max' => t('Slider title must not exceed 255 characters'),

            'image.image' => t('Image must be an image file'),
            'image.mimes' => t('Image must be a file of type: jpeg, png, jpg, gif, svg, webp'),
            'image.max' => t('Image file size must not exceed 2MB'),

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
