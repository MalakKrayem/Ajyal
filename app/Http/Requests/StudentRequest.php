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
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id=$this->route('student');
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:students,email,'.$id,
            'password' => 'required|string|min:8',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg',
            'phone' => 'required|string|max:255|unique:students,phone,'.$id,
            'address' => 'required|string|max:255',
            'rate' => 'in:Featured,Junior,Average,Unclassified',
            'transport' => 'integer|min:0',
            'status' => 'required|in:active,inactive',
            'total_income' => 'numeric|min:0',
            'total_jobs' => 'integer|min:0',
            'gender'=>'required|string|in:female,male',
           // 'group_id'=>'required|integer|exists:groups,id'
        ];
    }
}