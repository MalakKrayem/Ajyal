<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $id=$this->route('user');
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,".$id,
            'password' => "required|string|min:8|max:15",
            'gender'=>'required|string|in:female,male',
            'image'=>'mimes:jpg,png',
            'phone'=>'required|numeric|unique:users,phone,'.$id,
            'overview' => 'string|max:255',
            'position_description'=>'required|string|max:255'
        ];
    }
}
