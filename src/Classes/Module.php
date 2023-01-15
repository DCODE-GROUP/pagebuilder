<?php

namespace Dcodegroup\PageBuilder\Classes;

abstract class Module
{
    /**
     * @return mixed
     */
    abstract public static function template();

    /**
     * @return array
     */
    public static function module()
    {
        $template = static::template();
        foreach ($template['fields'] as &$field) {
            unset($field['rules']);
        }

        return $template;
    }
}
