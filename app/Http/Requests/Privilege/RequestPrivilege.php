<?php

namespace App\Http\Requests\Privilege;

use Illuminate\Foundation\Http\FormRequest;

class RequestPrivilege extends FormRequest
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
            'title' => 'required|max:255',
            'description' => 'max:5000',
            'link' => 'nullable|url',
            'register_deadline' => 'required|date|before:expire_date',
            'expire_date' => 'required|date|after_or_equal:register_deadline|after_or_equal:now',
            'thumbnail' => $this->isMethod('post') 
                ? 'required|mimes:jpeg,png,jpg|max:10000'
                : 'nullable|mimes:jpeg,png,jpg|max:10000',
        ];
    }
}
