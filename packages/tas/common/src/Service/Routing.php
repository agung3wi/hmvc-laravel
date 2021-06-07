<?php

namespace Tas\Common\Service;

class Routing
{
    public $menu = [];

    public function addMenu($menu)
    {
        $this->menu[] = $menu;
    }
}
