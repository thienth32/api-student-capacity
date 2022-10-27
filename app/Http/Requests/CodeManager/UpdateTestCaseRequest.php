<?php

namespace App\Http\Requests\CodeManager;

use App\Rules\TestCaseRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTestCaseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'test_case' => [new TestCaseRule()]
        ];
    }
}