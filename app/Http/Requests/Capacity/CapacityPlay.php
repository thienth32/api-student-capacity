<?php

namespace App\Http\Requests\Capacity;

use Illuminate\Foundation\Http\FormRequest;

class CapacityPlay extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "name" => "required",
            "max_ponit" => "required",
            "description" => "required",
            "questions" =>   "required"
        ];
    }

    // public function messages()
    // {
    //     return [
    //         "name.required" => "Tên trò chơi không để trống !",
    //         "max_ponit.required" => "Điểm trò chơi không để trống !",
    //         "description.required" => "Chi tiết trò chơi không để trống !",
    //         "questions.required" => "Bộ câu hỏi không bỏ trống !",
    //     ];
    // }
}