<?php

namespace App\Services\Modules\MCodeLanguage;

use App\Models\CodeLanguage as ModelsCodeLanguage;

class CodeLanguage implements MCodeLanguageInterface
{
    public function __construct(private ModelsCodeLanguage $model)
    {
    }

    public function getCodeLanguage($id, $with = [])
    {
        return $this->model::whereId($id)->with($with)->first();
    }

    public function getAllCodeLanguage($with = [])
    {
        return $this->model::all()->load($with);
    }
}