<?php

namespace App\Http\Requests\CP;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'price' => 'nullable|numeric|min:0',
            'active' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ];
        foreach (config('app.locales') as $locale) {
            $rules['title.' . $locale] = 'required|string|max:255';
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
            'title.required' => t('Address Title is required'),
            'title.array' => t('Address Title must be provided in multiple languages'),
            'title.*.required' => t('Address Title is required'),
            'title.*.string' => t('Address Title must be a string'),
            'title.*.max' => t('Address Title must not exceed 255 characters'),
            'price.numeric' => t('Price must be a number'),
            'price.min' => t('Price must be at least 0'),

        ];
    }
    public function prepareForValidation()
    {
        $this->merge([
            'active' => $this->has('active') ? true : false,
        ]);
    }
}
