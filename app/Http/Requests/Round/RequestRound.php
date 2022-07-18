<?php

namespace App\Http\Requests\Round;

use Illuminate\Foundation\Http\FormRequest;

class RequestRound extends FormRequest
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
        $ruleName = 'required|max:255|regex:/^[0-9a-zA-Z_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễếệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\ ]+$/u|unique:rounds,name';
        if($this->route()->id) $ruleName = 'required|max:255|regex:/^[0-9a-zA-Z_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễếệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\ ]+$/u|unique:rounds,name,' . $this->route()->id . ',id';
        $rule = [
            'name' => $ruleName,
            'start_time' => "required",
            'end_time' => "required|after:start_time",
            'description' => "required",
            'contest_id' => "required",
            'type_exam_id' => "required",
        ];
        if(!$this->route()->id || $this->has('image'))  $rule = array_merge($rule, [
            'image' => 'required|required|mimes:jpeg,png,jpg|max:10000',
        ]);
        return $rule;
    }

    public function messages()
    {
        return [
            'name.required' => trans('validate.required'),
            'name.max' =>   trans('validate.max'),
            'name.unique' => trans('validate.unique'),
            'name.regex' => trans('validate.regex'),

            'image.mimes' => trans('validate.mimes'),
            'image.required' => trans('validate.required'),
            'image.max' => trans('validate.maxImage'),

            'start_time.required' => trans('validate.required'),

            'end_time.required' => trans('validate.required'),
            'end_time.after' => trans('validate.end_time:date_after'),

            'description.required' => trans('validate.required'),

            'contest_id.required' => trans('validate.required'),
            'contest_id.numeric' => trans('validate.numeric'),

            'type_exam_id.required' => trans('validate.required'),
            'type_exam_id.numeric' => trans('validate.numeric'),
        ];
    }
}
