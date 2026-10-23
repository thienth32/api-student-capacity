<?php

namespace App\Http\Requests\Enterprise;

use Illuminate\Foundation\Http\FormRequest;

class RequestsEnterprise extends FormRequest
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
        $ruleName =  'required|unique:enterprises,name';
        $ruleTaxNumber = 'required|unique:enterprises,tax_number';
        if ($this->route()->id) {
            $ruleName = 'required|unique:enterprises,name,' . $this->route()->id . ',id';
            $ruleTaxNumber = 'required|unique:enterprises,tax_number,' . $this->route()->id . ',id';    
        }
        $rule = [
            'name' =>  $ruleName,
            'description' => "required",
            // 'link_web' => "required", //không bắt buộc trường website
            'tax_number' => $ruleTaxNumber,
            'contact_email' => 'required|max:255',
            'contact_name' => 'required|max:255',
            'contact_phone' => 'required|max:20',
        ];
        if (!$this->route()->id || $this->has('logo'))  $rule = array_merge($rule, [
            'logo' => 'required|required|mimes:jpeg,png,jpg|max:10000',
        ]);

        return $rule;
    }
    // public function messages()
    // {
    //     return [
    //         'name.required' => 'Chưa nhập trường này !',
    //         'name.unique' => 'Đã tồn tại trường này',
    //         'description.required' => 'Chưa nhập trường này !',
    //         'link_web.required' => 'Chưa nhập trường này !',
    //         'logo.mimes' => 'Sai định dạng !',
    //         'logo.required' => 'Chưa nhập trường này !',
    //         'logo.max' => 'Dung lượng ảnh không được vượt quá 10MB !',
    //     ];
    // }
}