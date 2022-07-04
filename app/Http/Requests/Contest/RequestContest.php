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
        $ruleName = 'required|max:255|unique:contests,name';
        if($this->route()->id) $ruleName = 'required|max:255|unique:contests,name,' . $this->route()->id . ',id';
        $rule =   [
            'name' => $ruleName,
            'top1' => 'required|numeric',
            'top2' => 'required|numeric',
            'top3' => 'required|numeric',
            'leave' => 'required|numeric',
            'date_start' => 'required|date',
            'register_deadline' => 'required|date',
            'description' => 'required',
        ];

        if(!$this->route()->id || $this->has('img'))  $rule = array_merge($rule, [
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
    public function messages()
    {
        return [
            'top1.required' => 'Chưa nhập trường này !',
            'top1.numeric' =>  'Sai định dạng !',
            'top2.required' => 'Chưa nhập trường này !',
            'top2.numeric' =>  'Sai định dạng !',
            'top3.required' => 'Chưa nhập trường này !',
            'top3.numeric' =>  'Sai định dạng !',
            'leave.required' => 'Chưa nhập trường này !',
            'leave.numeric' =>  'Sai định dạng !',

            'name.required' => 'Chưa nhập trường này !',
            'max_user.required' => 'Chưa nhập trường này !',
            'max_user.numeric' =>  'Sai định dạng !',
            'name.unique' => 'Tên cuộc thi đã tồn tại !',
            'name.max' => 'Độ dài kí tự không phù hợp !',
            'img.mimes' => 'Sai định dạng !',
            'img.required' => 'Chưa nhập trường này !',
            'img.max' => 'Dung lượng ảnh không được vượt quá 10MB !',
            'date_start.required' => 'Chưa nhập trường này !',
            'date_start.date' => 'Sai định dạng !',
            'start_register_time.required' => 'Chưa nhập trường này !',
            'start_register_time.date' => 'Sai định dạng !',

            'end_register_time.required' => 'Chưa nhập trường này !',
            'end_register_time.date' => 'Sai định dạng !',
            'register_deadline.required' => 'Chưa nhập trường này !',
            'register_deadline.date' => 'Sai định dạng !',
            'description.required' => 'Chưa nhập trường này !',
        ];
    }


//    protected function failedValidation(Validator $validator)
//    {
//        return back()->withErrors($validator)->withInput();
//    }

}
