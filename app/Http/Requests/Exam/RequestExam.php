<?php

namespace App\Http\Requests\Exam;

use Illuminate\Foundation\Http\FormRequest;

class RequestExam extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $ruleName = 'required|unique:exams,name|min:4|max:255';
        if ($this->route()->id) $ruleName = 'required|min:4|max:255|unique:exams,name,' . $this->route()->id . ',id';
        $rule = [
            'name' => $ruleName,
            'description' => 'required|min:4',
            'max_ponit' => 'required|numeric|min:0|max:1000',
            'ponit' => 'required|numeric|min:0|max:1000',
        ];
        return $rule;
    }

    // public function messages()
    // {
    //     return [
    //         'name.required' => trans('validate.required'),
    //         'name.unique' => trans('validate.unique'),
    //         'name.min' => trans('validate.min'),
    //         'description.min' => trans('validate.min'),
    //         'name.max' => trans('validate.max'),
    //         'description.required' => trans('validate.required'),
    //         'max_ponit.required' => trans('validate.required'),
    //         'max_ponit.numeric' => trans('validate.numeric'),
    //         'max_ponit.min' => trans('validate.min'),
    //         'max_ponit.max' => trans('validate.max'),

    //         'ponit.numeric' => trans('validate.numeric'),
    //         'ponit.max' => trans('validate.max'),
    //         'ponit.min' => trans('validate.min'),
    //         'ponit.required' => trans('validate.required'),
    //     ];
    // }
}