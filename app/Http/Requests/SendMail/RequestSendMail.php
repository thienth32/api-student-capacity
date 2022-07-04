<?php

namespace App\Http\Requests\SendMail;

use Illuminate\Foundation\Http\FormRequest;

class RequestSendMail extends FormRequest
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
            'content' => 'required|min:2',
            'subject' => 'required|min:2',
        ];
    }

    public function messages()
    {
        return [
            'content.required' => 'Trường nội dung không được bỏ trống !',
            'content.min' => 'Trường nội dung không được nhỏ quá 2 ký tự !',
            'subject.min' => 'Trường tiêu đề không được nhỏ quá 2 ký tự !',
            'subject.required' => 'Trường tiêu đề không được bỏ trống !',
        ];
    }

}
