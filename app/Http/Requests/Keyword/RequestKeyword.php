<?php

namespace App\Http\Requests\Keyword;

use Illuminate\Foundation\Http\FormRequest;

class RequestKeyword extends FormRequest
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

    public function rules()
    {
        $ruleKeyword = 'required|unique:keywords,keyword|min:4|max:255';
        if ($this->route()->id) $ruleKeyword = 'required|min:4|max:255|unique:keywords,keyword,' . $this->route()->id . ',id';
        $rule = [
            'keyword' => $ruleKeyword,
            'keyword_en' => 'required|min:4',
            'keyword_slug' => 'required|min:4',
            'type' => 'required|integer',
            'status' => 'required|integer',
        ];
        return $rule;
    }
}