<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MentorRequest extends FormRequest
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
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:mentors',
            'password' => 'required|string|min:8|max:15',
            'gender'=>'required|string|in:female,male',
            'phone'=>'numeric',
            'image'=>'mimes:jpg,png',
            'overview' => 'string|max:255',
        ];
    }
}
