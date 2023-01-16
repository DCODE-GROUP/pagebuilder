<?php

namespace Dcodegroup\PageBuilder\Modules;

use Dcodegroup\PageBuilder\Classes\Module;

class TwoColumnWithImage extends Module
{
    public function template(): array
    {
        return [
            'name' => 'Two column with Image',
            'icon' => 'images',
            'fields' => [
                'body' => [
                    'type' => 'wysiwyg',
                    'rules' => ['required'],
                    'value' => null,
                ],
                'image' => [
                    'type' => 'image',
                    'rules' => ['required'],
                    'value' => null,
                ],
                'imageLink' => [
                    'type' => 'text',
                    'rules' => [],
                    'value' => null,
                ],
                'rounded' => [
                    'type' => 'boolean',
                    'rules' => [],
                    'value' => false,
                ],
                'icon' => [
                    'type' => 'image',
                    'rules' => [],
                    'value' => null,
                ],
                'anchor' => [
                    'type' => 'text',
                    'rules' => [],
                    'value' => null,
                ],
                'padding' => [
                    'type' => 'boolean',
                    'rules' => [],
                    'value' => true,
                ],
                'style' => [
                    'type' => 'select',
                    'rules' => [],
                    'options' => ['dark', 'boxed-white'],
                    'value' => 'dark',
                ],
                'alignment' => [
                    'type' => 'select',
                    'rules' => [],
                    'options' => ['left', 'right'],
                    'value' => 'right',
                ],
            ],
        ];
    }
}
