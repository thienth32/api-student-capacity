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
        return [
            'on_date' => 'required|date',
            'time' => 'required|numeric',
            'type' => 'required',
            'exam_code' => 'required'
        ];
    }
}