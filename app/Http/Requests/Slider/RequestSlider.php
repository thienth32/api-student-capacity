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
        if(!$this->route()->id || $this->has('image_url'))  $rule = array_merge($rule, [
            'image_url' => 'image|mimes:jpeg,png,jpg|max:10000',
        ]);
        return $rule;
    }

    public function messages()
    {
        return [
            'link_to.required' => 'Không để trống trường này !',
            'start_time.required' => 'Không để trống trường này !',
            'end_time.required' => 'Không để trống trường này !',
            'end_time.after' => 'Trường này thời gian nhỏ hơn trường thời gian bắt đầu  !',
            'image_url.image' => 'Không để trống trường này !',
            'image_url.mimes' => 'Trường này không đúng định dạng  !',
            'image_url.max' => 'Trường này kích cỡ quá lớn  !',
        ];
    }
}
