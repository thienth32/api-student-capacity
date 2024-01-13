<?php

namespace App\Http\Controllers;

use Illuminate\Routing\RouteUrlGenerator;
use Illuminate\Contracts\Routing\UrlRoutable;

class CustomUrlResolver extends RouteUrlGenerator
{
    public function to($route, $parameters = [], $absolute = true)
    {
        // Thay đổi đường dẫn gốc tại đây
        $this->forceRootUrl('http://example.com');

        return parent::to($route, $parameters, $absolute);
    }
}
