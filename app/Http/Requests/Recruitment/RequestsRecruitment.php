<?php

namespace App\Http\Requests\Recruitment;

use Illuminate\Foundation\Http\FormRequest;

class RequestsRecruitment extends FormRequest
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
        $ruleName = 'required|max:255|unique:recruitments,name';
        if ($this->route()->id) {
            $ruleName = 'required|max:255|unique:recruitments,name,' . $this->route()->id . ',id';
        }
        $rule = [
            'name' =>  $ruleName,
            'short_description' => 'required|max:255',
            'description' => 'required',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'amount' => 'required|numeric|min:1',
            'cost' => 'required|numeric|min:1',
        ];
        if (!$this->route()->id || $this->has('image_url'))  $rule = array_merge($rule, [
            'image' => 'required|required|mimes:jpeg,png,jpg|max:10000',
            'start_time' => 'required|after_or_equal:today',
        ]);
        return $rule;
    }
    public function messages()
    {
        return [
            'name.required' => 'Chưa nhập trường này !',
            'name.unique' => 'trường đã tồn tại !',
            'start_time.after_or_equal' => 'Thời gian bắt đầu phải sau hoặc bằng ngày hiện tại. ',
            'start_time.required' => 'Chưa nhập trường này !',
            'end_time.required' => 'Chưa nhập trường này !',
            'end_time.after' => 'Thời gian kết thúc không được nhỏ hơn thời gian bắt đầu !',
            'description.required' => 'Chưa nhập trường này !',
            'short_description.required' => 'Chưa nhập trường này !',
            'short_description.max' => 'Trường không được quá 225 ký tự !',
            'image.mimes' => 'Sai định dạng !',
            'image.required' => 'Chưa nhập trường này !',
            'image.max' => 'Dung lượng ảnh không được vượt quá 10MB !',
            'amount.min' => 'Trường tối thiểu là 1',
            'amount.numeric' => 'Trường phải là số',
            'amount.required' =>  'Chưa nhập trường này !',
            'cost.min' => 'Trường tối thiểu là 1',
            'cost.numeric' => 'Trường phải là số',
            'cost.required' =>  'Chưa nhập trường này !',

        ];
    }
}
