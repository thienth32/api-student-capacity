<?php

namespace App\Http\Requests\Job;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if (request()->type == "game_type_1" || request()->type == "game_type_2")
            return [
                'on_date' => 'required|date',
                'time' => 'required|numeric',
                'type' => 'required',
                'exam_code' => 'required',
                'status' => 'required'
            ];

        return [
            'mails' => 'required',
            'subject' => 'required',
            'content' => 'required',
            'on_date' => 'required|date',
            'type' => 'required',
            'status' => 'required',
        ];
    }
}