<?php

namespace App\Http\Requests\Admin;

use App\Models\Inquiry;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InquiryStatusUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var \App\Models\Inquiry $inquiry */
        $inquiry = $this->route('inquiry');

        return $this->user()->can('updateStatus', $inquiry);
    }

    public function rules(): array
    {
        return [
            'status' => [
                'required',
                'string',
                Rule::in([
                    Inquiry::STATUS_NEW,
                    Inquiry::STATUS_IN_PROGRESS,
                    Inquiry::STATUS_REPLIED,
                    Inquiry::STATUS_ARCHIVED,
                ]),
            ],
        ];
    }
}
