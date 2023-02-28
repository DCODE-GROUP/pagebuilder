<?php

namespace Dcodegroup\PageBuilder\Services;

use Illuminate\Support\Collection;

class MacroService
{
    /**
     * @return array
     */
    public static function constructSelectOptions(Collection $collection, $key, $value)
    {
        $options = [];

        $collection->each(function ($item) use (&$options, $key, $value) {
            $options[] = [
                'label' => $item->{$value},
                'code' => $item->{$key},
            ];
        });

        return $options;
    }
}
