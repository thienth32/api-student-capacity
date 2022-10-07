<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class RequestsPost extends FormRequest
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
        $ruleTitle = 'required|max:255|unique:posts,title';
        $ruleSlug =  'required|unique:posts,slug';
        $ruleCodeRecruiment = 'required|max:20|regex:/^[0-9a-zA-Z_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễếệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\ ]+$/u|unique:posts,code_recruitment';
        if ($this->route()->id) {
            // dd($this->route()->id);
            $ruleTitle = 'required|max:255|unique:posts,title,' . $this->route()->id;
            $ruleSlug =  'required|unique:posts,slug,' . $this->route()->id . ',id';
            $ruleCodeRecruiment = 'required|max:20|regex:/^[0-9a-zA-Z_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễếệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\ ]+$/u|unique:posts,code_recruitment,' . $this->route()->id . ',id';
        }

        $rule = [
            'title' => $ruleTitle,
            'description' => 'required',
            'published_at' => 'required|after_or_equal:today',
            'slug' =>   $ruleSlug,
            'code_recruitment' =>
            request()->recruitment_id != 0 ?
                $ruleCodeRecruiment :
                function ($nullRole, $value = null, $fail) {
                    if ($value != null) {
                        return $fail('Trường chỉ áp dụng với bài viết tuyển dụng');
                    }
                },
            'content' => request()->content != null  ? 'required' : '',
            'link_to' => request()->link_to != null  ? 'required' : '',
        ];

        if (!$this->route()->id || $this->has('image_url'))  $rule = array_merge($rule, [
            'thumbnail_url' => 'required|required|mimes:jpeg,png,jpg|max:10000',
        ]);
        return $rule;
    }
    public function messages()
    {
        return [
            'slug.required' => 'Không được bỏ trống slug !',
            'slug.unique' => 'trường đã tồn tại !',
            'title.required' => 'Chưa nhập trường này !',
            'title.unique' => 'trường đã tồn tại !',
            'title.max' => 'Trường không được quá 225 ký tự',
            'published_at.after_or_equal' => 'Thời gian bắt đầu phải sau hoặc bằng ngày hiện tại. ',
            'published_at.required' => 'Chưa nhập trường này !',
            'description.required' => 'Chưa nhập trường này !',
            'content.required' => 'Chưa nhập trường này !',
            'link_to.required' => 'Chưa nhập trường này !',
            'thumbnail_url.mimes' => 'Sai định dạng !',
            'code_recruitment.required' => 'Chưa nhập trường này !',
            'code_recruitment.max' => 'Trường không được quá 20 ký tự !',
            'code_recruitment.regex' => 'Trường phải viết hoa không dấu và không có ký tự đặc biệt!',
            'code_recruitment.unique' => 'Trường đã tồn tại !',

            'thumbnail_url.required' => 'Chưa nhập trường này !',
            'thumbnail_url.max' => 'Dung lượng ảnh không được vượt quá 10MB !',
        ];
    }
}
