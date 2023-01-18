<?php

namespace Dcodegroup\PageBuilder\Modules;

use Dcodegroup\PageBuilder\Classes\Module;

class ImageSlider extends Module
{
    protected string $name = 'Image Slider';
    protected string $icon = 'images';

    public function fields(): array
    {
        return [
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
        ];
    }
}
