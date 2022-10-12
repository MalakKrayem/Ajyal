<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendenceRequest extends FormRequest
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
            'course_id' => 'required|exists:courses,id',
            'date' => 'required|string',
            'status' => 'required|in:attend,absent',
            'student_id' => 'required|exists:students,id',
        ];
    }
}
