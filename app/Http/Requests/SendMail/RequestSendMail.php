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
        return auth()->check();
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

    // public function messages()
    // {
    //     return [
    //         'content.required' => trans('validate.required'),
    //         'content.min' => trans('validate.min'),
    //         'subject.min' => trans('validate.min'),
    //         'subject.required' => trans('validate.required'),
    //     ];
    // }

}