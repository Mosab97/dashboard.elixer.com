<?php

namespace App\Http\Requests\CP;

use Illuminate\Foundation\Http\FormRequest;

class ContactUsRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'subject' => 'required|string',
            'message' => 'required|string',
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
            'name.required' => t('Name is required'),
            'name.string' => t('Name must be a string'),
            'name.max' => t('Name must not exceed 255 characters'),
            'email.required' => t('Email is required'),
            'email.email' => t('Email must be a valid email address'),
            'phone.string' => t('Phone must be a string'),
            'subject.required' => t('Subject is required'),
            'subject.string' => t('Subject must be a string'),
            'message.required' => t('Message is required'),
            'message.string' => t('Message must be a string'),
        ];
    }
    public function prepareForValidation()
    {
        $this->merge([
        ]);
    }
}
