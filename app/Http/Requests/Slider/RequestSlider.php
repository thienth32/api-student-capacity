<?php

namespace App\Http\Requests\Slider;

use Illuminate\Foundation\Http\FormRequest;

class RequestSlider extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        $rule = [
            'link_to' => 'required',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',

        ];
        if (!$this->route()->id || $this->has('image_url'))  $rule = array_merge($rule, [
            'image_url' => 'image|mimes:jpeg,png,jpg|max:10000',
        ]);
        return $rule;
    }

    // public function messages()
    // {
    //     return [
    //         'link_to.required' => trans('validate.required'),
    //         'start_time.required' => trans('validate.required'),
    //         'end_time.required' => trans('validate.required'),
    //         'end_time.after' => trans('validate.end_time:date_after'),
    //         'image_url.image' => trans('validate.image'),
    //         'image_url.mimes' => trans('validate.mimes'),
    //         'image_url.max' => trans('validate.maxImage'),
    //     ];
    // }
}