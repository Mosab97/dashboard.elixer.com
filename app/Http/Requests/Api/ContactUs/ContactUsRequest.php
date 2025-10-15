<?php

namespace App\Http\Requests\Api\ContactUs;

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
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
            'phone.required' => t('Phone is required'),
            'email.required' => t('Email is required'),
            'email.email' => t('Email is not a valid email address'),
            'subject.required' => t('Subject is required'),
            'subject.max' => t('Subject must not exceed 255 characters'),
            'message.required' => t('Message is required'),
            'message.max' => t('Message must not exceed 5000 characters'),
        ];
    }
}
