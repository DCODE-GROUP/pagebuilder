<?php

namespace Dcodegroup\PageBuilder\Modules;

use Dcodegroup\PageBuilder\Classes\Module;

class ImageSlider extends Module
{
    public function configuration(): array
    {
        return [
            'name' => 'Image Slider',
            'icon' => 'images',
            'fields' => [
                'items' => [
                    'type' => 'array',
                    'rules' => ['nullable', 'max:255'],
                    'value' => [],
                ],
                'interval' => [
                    'type' => 'integer',
                    'rules' => [],
                    'value' => null,
                ],
                'contained' => [
                    'type' => 'boolean',
                    'rules' => [],
                    'value' => true,
                ],
                'margins' => [
                    'type' => 'boolean',
                    'rules' => [],
                    'value' => true,
                ],
                'fullHeight' => [
                    'type' => 'boolean',
                    'rules' => [],
                    'value' => false,
                ],
            ],
        ];
    }
}
