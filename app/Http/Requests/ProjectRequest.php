<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:255',
            'image'=>'string|mims:pjpeg,png,jpg,gif,svg',
            'budget'=>'numeric',
            'status'=>'string|in:draft,completed,ongoing',
            'start_date'=>'string',
            'end_date'=>'string',
        ];
    }
}
