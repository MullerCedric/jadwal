<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamSessionStoreRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'nullable|integer|min:0',
            'location' => 'exists:locations,id',
            'title' => 'required|min:4',
            'indications' => 'nullable|string',
            'deadline' => 'date|date_format:Y-m-d|after:+5 days',
            'sent_at' => 'nullable|date',
        ];
    }
}
