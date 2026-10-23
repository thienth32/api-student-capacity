<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;

class RequestService extends FormRequest
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
            'name' => 'required|max:255',
            'description' => 'max:1000',
            'link' => 'nullable|url',
            'thumbnail' => $this->isMethod('post') 
                ? 'required|mimes:jpeg,png,jpg|max:10000'
                : 'nullable|mimes:jpeg,png,jpg|max:10000',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được bỏ trống',
            'name.max' => 'Tên không được lớn hơn 255 ký tự',
            'description' => 'Mô tả không được dài hơn 1000 ký tự',
        ];
    }
}
