<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DraftPreferenceStoreRequest extends FormRequest
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
            'teacher_id' => 'nullable|integer|min:0',
            'exam_session_id' => 'nullable|integer|min:0',
            'values' => 'nullable|json',
            'about' => 'nullable|string',
        ];
    }
}
