<?php

namespace App\Http\Requests\CP;

use App\Enums\ProjectAttachmentType;
use Illuminate\Foundation\Http\FormRequest;

class AttachmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $id = $this->route('attachment') ? $this->route('attachment')->id : null;

        return [
            'attachment_file' => [
                $id ? 'nullable' : 'required',
                'file',
                'max:10240', // 10MB max file size
                'mimes:jpg,jpeg,png,gif'
            ],
            // 'attachment_type_id' => 'required|integer|exists:constants,id',
            'attachable_type' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!class_exists($value)) {
                        $fail('The selected attachable type is invalid.');
                    }
                }
            ],
            'attachable_id' => 'required|integer|min:1'
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'attachment_file.required' => 'Please select a file to upload.',
            'attachment_file.file' => 'The uploaded item must be a valid file.',
            'attachment_file.max' => 'The file size must not exceed 10MB.',
            'attachment_file.mimes' => 'Only images are allowed.',
            'attachment_type_id.required' => 'Please select an attachment type.',
            'attachment_type_id.exists' => 'The selected attachment type is invalid.',
            'attachable_type.required' => 'Attachable type is required.',
            'attachable_id.required' => 'Attachable ID is required.',
        ];
    }
}
