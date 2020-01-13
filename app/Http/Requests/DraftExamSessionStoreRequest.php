<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DraftExamSessionStoreRequest extends FormRequest
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
            'title' => 'nullable|string',
            'indications' => 'nullable|string',
            'deadline' => 'nullable|date',
            'sent_at' => 'nullable|date',
        ];
    }
}
