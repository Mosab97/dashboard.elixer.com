<?php

namespace App\Http\Requests\CP;

use Illuminate\Foundation\Http\FormRequest;

class FAQRequest extends FormRequest
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
            'question' => 'required|array',
            'answer' => 'nullable|array',
            'active' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ];
        foreach (config('app.locales') as $locale) {
            $rules['question.' . $locale] = 'required|string|max:255';
            $rules['answer.' . $locale] = 'nullable|string|max:10000';
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
            'question.required' => t('Question is required'),
            'question.array' => t('Question must be provided in multiple languages'),
            'question.*.required' => t('Question is required'),
            'question.*.string' => t('Question must be a string'),
            'question.*.string' => t('Question must be a string'),
            'question.*.max' => t('Question must not exceed 255 characters'),

            'answer.array' => t('Answer must be provided in multiple languages'),
            'answer.*.string' => t('Answer must be a string'),
            'answer.*.max' => t('Answer must not exceed 255 characters'),

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
