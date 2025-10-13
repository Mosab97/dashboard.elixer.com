<?php

namespace App\Http\Requests\CP;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRateRequest extends FormRequest
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
            'name' => ['required', 'array'],
            'description' => ['required', 'array'],
            'rate' => ['required', 'integer', 'min:1', 'max:5'],
            'active' => ['boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:' . implode(', ', config('app.image_mimes')), 'max:2048'],
        ];

        foreach (config('app.locales') as $locale) {
            $rules['name.' . $locale] = 'required|string|max:255';
            $rules['description.' . $locale] = 'required|string|max:500';
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
        $messages =  [
            'rate.required' => t('Rate is required'),
            'rate.integer' => t('Rate must be an integer'),
            'rate.min' => t('Rate must be at least 1'),
            'rate.max' => t('Rate must be at most 5'),
            'active.boolean' => t('Active status must be true or false'),
            'order.integer' => t('Order must be a number'),
            'order.min' => t('Order must be at least 0'),
            'image.image' => t('Image must be an image file'),
            'image.mimes' => t('Image must be a file of type: ' . implode(', ', config('app.image_mimes'))),
            'image.max' => t('Image file size must not exceed 2MB'),
        ];
        foreach (config('app.locales') as $locale) {
            $messages['name.' . $locale . '.required'] = t('Name is required in ' . $locale);
            $messages['name.' . $locale . '.string'] = t('Name must be a string in ' . $locale);
            $messages['name.' . $locale . '.max'] = t('Name must not exceed 255 characters in ' . $locale);
            $messages['description.' . $locale . '.required'] = t('Description is required in ' . $locale);
            $messages['description.' . $locale . '.string'] = t('Description must be a string in ' . $locale);
            $messages['description.' . $locale . '.max'] = t('Description must not exceed 500 characters in ' . $locale);
        }
        return $messages;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'active' => $this->has('active') ? true : false,
        ]);
    }
}
