<?php

namespace App\Http\Requests\Admin;

use App\Models\Inquiry;
use Illuminate\Foundation\Http\FormRequest;

class InquiryReplyRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var \App\Models\Inquiry $inquiry */
        $inquiry = $this->route('inquiry');

        return $this->user()->can('reply', $inquiry);
    }

    public function rules(): array
    {
        return [
            'reply_subject' => ['nullable', 'string', 'max:255'],
            'reply_message' => ['required', 'string', 'min:5'],
            'send_email' => ['nullable', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'send_email' => $this->boolean('send_email'),
        ]);
    }
}
