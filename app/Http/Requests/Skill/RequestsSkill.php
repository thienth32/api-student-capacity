<?php

namespace App\Http\Requests\Skill;

use Illuminate\Foundation\Http\FormRequest;

use function GuzzleHttp\Promise\all;

class RequestsSkill extends FormRequest
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
        $ruleName =  'required|max:255|unique:skills,name';
        $ruleShort_name = 'required|max:20|unique:skills,short_name';
        if ($this->route()->id) {
            $ruleName = 'required|max:255|unique:skills,name,' . $this->route()->id . ',id';
            $ruleShort_name = 'required|max:20|unique:skills,short_name,' . $this->route()->id . ',id';
        }
        $rule = [
            'name' =>  $ruleName,
            'short_name' =>  $ruleShort_name,
            'description' => 'required',
            // 'major_id' => 'required',

        ];
        if (!$this->route()->id || $this->has('image_url'))  $rule = array_merge($rule, [
            'image_url' => 'required|mimes:jpeg,png,jpg|max:10000',
        ]);
        return $rule;
    }
    public function messages()
    {
        return [
            'name.required' => 'Chưa nhập trường này !',
            'name.unique' => 'trường đã tồn tại !',
            'name.max' => 'Độ dài kí tự không phù hợp !',
            'short_name.required' => 'Chưa nhập trường này !',
            'short_name.max' => 'Độ dài kí tự không phù hợp !',
            'short_name.unique' => 'Đã tồn tại trường này !',
            'image_url.mimes' => 'Sai định dạng !',
            'image_url.required' => 'Chưa nhập trường này !',
            'image_url.max' => 'Dung lượng ảnh không được vượt quá 10MB !',
            'description.required' => 'Chưa nhập trường này !',
        ];
    }
}
