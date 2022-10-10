<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public static function rules()
    {
        return [
            'group_id'=>'required|integer|exists:groups,id',
            'mentor_id'=>'required|integer|exists:mentors,id',
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:255',
            'image'=>'string|mims:pjpeg,png,jpg,gif,svg',
            'budget'=>'numeric',
            'participants_count'=>'integer',
            'hour_count'=>'integer',
            'start_date'=>'string',
            'end_date'=>'string',
            'status'=>'string|in:draft,completed,ongoing',


        ];
    }
}
