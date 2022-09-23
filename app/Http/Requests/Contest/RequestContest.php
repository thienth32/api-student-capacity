<?php

namespace App\Http\Requests\Contest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class RequestContest extends FormRequest
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
        $ruleName = 'required|max:255';
        // if($this->route()->id) $ruleName = 'required|max:255|unique:contests,name,' . $this->route()->id . ',id';
        $rule =   [
            'name' => $ruleName,
            'top1' => 'required|numeric',
            'top2' => 'required|numeric',
            'top3' => 'required|numeric',
            'leave' => 'required|numeric',
            'date_start' => 'required|date',
            'register_deadline' => 'required|date|after_or_equal:date_start',
            'description' => 'required',
            'post_new' => 'required'
        ];

        if (!$this->route()->id || $this->has('img'))  $rule = array_merge($rule, [
            'img' => 'required|mimes:jpeg,png,jpg|max:10000',
        ]);

        if (request('type') == config('util.TYPE_CONTEST')) $rule = array_merge($rule, [
            'max_user' => 'required|numeric',
            'start_register_time' => 'required|date',
            'end_register_time' => 'required|date',
        ]);
        return $rule;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    // public function messages()
    // {
    //     return [
    //         'top1.required' => trans('validate.required'),
    //         'top1.numeric' =>  trans('validate.numeric'),
    //         'top2.required' => trans('validate.required'),
    //         'top2.numeric' =>  trans('validate.numeric'),
    //         'top3.required' => trans('validate.required'),
    //         'top3.numeric' =>  trans('validate.numeric'),
    //         'leave.required' => trans('validate.required'),
    //         'leave.numeric' =>  trans('validate.numeric'),

    //         'name.required' => trans('validate.required'),
    //         'post_new.required' => trans('validate.required'),
    //         'max_user.required' => trans('validate.required'),
    //         'max_user.numeric' =>  trans('validate.numeric'),
    //         'name.unique' => trans('validate.unique'),
    //         'name.max' => trans('validate.max'),
    //         'img.mimes' => trans('validate.mimes'),
    //         'img.required' => trans('validate.required'),
    //         'img.max' => trans('validate.maxImage'),
    //         'date_start.required' => "Chưa nhập thời gian bắt đầu ",
    //         'date_start.date' => trans('validate.date'),
    //         'start_register_time.required' => "Chưa nhập thời gian bắt đầu đăng ký !",
    //         'start_register_time.date' => trans('validate.date'),

    //         'end_register_time.required' => "Chưa nhập thời gian kết thúc đăng ký !",
    //         'end_register_time.date' => trans('validate.date'),
    //         'register_deadline.required' => "Chưa nhập thời gian kết thúc",
    //         'register_deadline.after_or_equal' => trans('validate.end_time:date_after'),
    //         'register_deadline.date' => trans('validate.date'),
    //         'description.required' => trans('validate.required'),
    //     ];
    // }
}