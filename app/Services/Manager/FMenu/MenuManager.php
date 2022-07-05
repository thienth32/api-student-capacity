<?php

namespace App\Services\Manager\FMenu;

class MenuManager
{
    protected $menus = [];

    public function __construct()
    {
        $this->menus = config('menus');
    }

    public function add($menu)
    {
        $this->menus[] = $menu;
    }

    public function get()
    {
        return $this->menus;
    }
}
