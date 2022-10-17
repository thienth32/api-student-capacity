<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TestCaseRule implements Rule
{

    public function __construct()
    {
    }

    public function passes($attribute, $value)
    {
        foreach ($value as $v) {
            if ($v['input'] == null || $v['output'] == null) return false;
        }
        return true;
    }

    public function message()
    {
        return 'Các trường nhập đầu vào đầu ra không được để null';
    }
}