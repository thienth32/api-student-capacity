<?php

namespace App\Services\Modules\MMajor;

interface MMajorInterface
{
    public function getRatingUserByMajorSlug($slug);
    public function getRankUserCapacity($slug);
}