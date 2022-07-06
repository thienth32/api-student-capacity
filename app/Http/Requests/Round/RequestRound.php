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
        $rule = [
            'name' => "required|max:255|regex:/^[0-9a-zA-Z_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễếệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\ ]+$/u|unique:rounds,name," . $round->id,
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
            'name.required' => 'Chưa nhập trường này !',
            'name.max' => 'Độ dài kí tự không phù hợp !',
            'name.unique' => 'Đã tồn tại trong cơ sở dữ liệu !',
            'name.regex' => 'Trường name không chứ kí tự đặc biệt !',

            'image.mimes' => 'Sai định dạng !',
            'image.required' => 'Chưa nhập trường này !',
            'image.max' => 'Dung lượng ảnh không được vượt quá 10MB !',

            'start_time.required' => 'Chưa nhập trường này !',

            'end_time.required' => 'Chưa nhập trường này !',
            'end_time.after' => 'Thời gian kết thúc không được nhỏ hơn  thời gian bắt đầu !',

            'description.required' => 'Chưa nhập trường này !',

            'contest_id.required' => 'Chưa nhập trường này !',
            'contest_id.numeric' => 'Sai định dạng !',

            'type_exam_id.required' => 'Chưa nhập trường này !',
            'type_exam_id.numeric' => 'Sai định dạng !',
        ];
    }
}
