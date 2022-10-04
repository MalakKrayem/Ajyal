<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdvertisingRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'details' => 'required|string|max:500',
            'image' => 'string|max:255',
            'notes' => 'string|max:255',
            'attachment' => 'required|string',
            'deadline' => 'required|string|max:100',
            'status' => 'required|string|in:published,unpublished',
        ];
    }
}
