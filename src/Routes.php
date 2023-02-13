<?php

namespace Dcodegroup\PageBuilder;

class Routes
{
    public static function front(string $action): string
    {
        return config('page-builder.routing.front.name_prefix').$action;
    }

    public static function admin(string $action): string
    {
        return config('page-builder.routing.admin.name_prefix').$action;
    }
}
