<?php

namespace Dcodegroup\PageBuilder\Modules;

use Dcodegroup\PageBuilder\Classes\Module;

class TwoColumn extends Module
{
    public function configuration(): array
    {
        return [
            'name' => 'Two column',
            'icon' => 'columns',
            'fields' => [
                'heading' => [
                    'type' => 'text',
                    'rules' => ['required', 'max:255'],
                    'value' => null,
                ],
                'body_one' => [
                    'type' => 'wysiwyg',
                    'rules' => ['required'],
                    'value' => null,
                ],
                'body_two' => [
                    'type' => 'wysiwyg',
                    'rules' => ['required'],
                    'value' => null,
                ],
                'padding' => [
                    'type' => 'boolean',
                    'rules' => [],
                    'value' => true,
                ],
            ],
        ];
    }
}
