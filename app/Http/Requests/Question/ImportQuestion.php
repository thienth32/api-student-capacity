<?php

namespace App\Http\Requests\Question;

use Illuminate\Foundation\Http\FormRequest;

class ImportQuestion extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "ex_file" => "required|mimes:xlsx"
        ];
    }

    public function messages()
    {
        return [
            "ex_file.required" => "Chưa nhập file , vui lòng nhập file !",
            "ex_file.mimes" => "File không đúng địng dạng xlsx !"
        ];
    }
}