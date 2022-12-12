<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FreelanceRequest extends FormRequest
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
        return [
            'platform_id' => 'required|integer|exists:platforms,id',
            'student_id' => 'required|integer|exists:students,id',
            'group_id' => 'required|integer|exists:groups,id',
            'job_title' => 'required|string|max:255',
            'job_description' => 'string|max:500',
            'job_link' => 'string',
            'salary' => 'required|integer',
            'client_feedback' => 'string',
            'status' => 'required|string|in:completed,ongoing',
            'notes' => 'string|max:500',
        ];
    }
}