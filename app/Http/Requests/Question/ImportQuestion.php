<?php

namespace App\Http\Requests\Question;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ImportQuestion extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "ex_file" => "required|mimes:xlsx,csv"
        ];
    }

    public function messages()
    {
        return [
            "ex_file.required" => "Chưa nhập file , vui lòng nhập file !",
            "ex_file.mimes" => "File không đúng địng dạng xlsx,csv !"
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        return throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
            'status' => false
        ], 404));
    }
}