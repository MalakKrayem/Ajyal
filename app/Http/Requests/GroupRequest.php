<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public  function authorize()
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
            'category_id'=>'required|integer|exists:categories,id',
            'project_id'=>'integer|exists:projects,id',
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:500',
            'budget'=>'numeric',
            'hour_count'=>'integer',
            'participants_count'=>'integer',
            'start_date'=>'date',
            'end_date'=>'date',
            'status'=>'string|in:draft,completed,ongoing',
            'image'=>'mimes:png,jpg,jpeg',

        ];
    }
}
