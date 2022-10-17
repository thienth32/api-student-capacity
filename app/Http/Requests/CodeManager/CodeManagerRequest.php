<?php

namespace App\Http\Requests\CodeManager;

use App\Rules\TestCaseRule;
use Illuminate\Foundation\Http\FormRequest;

class CodeManagerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        $currentAction = $this->route()->getActionMethod();
        if ($currentAction == "update") return [
            'name' => 'required',
            'content' => 'required',
            'top1' => 'required',
            'top2' => 'required',
            'top3' => 'required',
            'leave' => 'required',
        ];
        return [
            'name' => 'required',
            'content' => 'required',
            'languages' => 'required',
            'top1' => 'required',
            'top2' => 'required',
            'top3' => 'required',
            'leave' => 'required',
            'test_case' => [new TestCaseRule()]
        ];
    }
}