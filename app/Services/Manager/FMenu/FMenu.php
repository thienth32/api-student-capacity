<?php

namespace App\Services\Manager\FMenu;
use Illuminate\Support\Facades\Facade;

class FMenu extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'menu';
    }
}
