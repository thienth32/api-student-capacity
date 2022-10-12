<?php

namespace App\Services\Modules\MCodeLanguage;

interface MCodeLanguageInterface
{
    public function getCodeLanguage($id, $with = []);

    public function getAllCodeLanguage($with = []);
}