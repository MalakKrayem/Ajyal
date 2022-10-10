<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:students',
            'password' => 'required|string|min:8',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg',
            'phone' => 'required|string|max:255|unique:students',
            'address' => 'required|string|max:255',
            'rate' => 'integer|min:0',
            'transport' => 'integer|min:0',
            'status' => 'required|in:active,inactive',
            'total_income' => 'numeric|min:0',
            'total_jobs' => 'integer|min:0',
            'gender'=>'required|string|in:female,male',
            'group_id'=>'required|integer|exists:groups,id'
        ];
    }
}