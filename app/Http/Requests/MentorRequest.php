<?php

namespace App\Http\Requests;

use App\Models\Mentor;
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
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id=$this->route('mentor');
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => "required|email|unique:mentors,email,".$id,
            'password' => 'required|string|min:8|max:15',
            'gender'=>'required|string|in:female,male',
            'phone'=>'required|numeric|unique:mentors,phone,'.$id,
            'image'=>'mimes:jpg,png',
            'overview' => 'string|max:255',
        ];
    }
}
