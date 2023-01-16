<?php

namespace Dcodegroup\PageBuilder\Modules;

use Dcodegroup\PageBuilder\Classes\Module;

class Heading extends Module
{
    public function template(): array
    {
        return [
            'name' => 'Heading',
            'icon' => 'heading',
            'className' => self::class,
            'fields' => [
                'heading' => [
                    'type' => 'text',
                    'rules' => ['required', 'max:255'],
                    'value' => null,
                ],
                'sub_heading' => [
                    'type' => 'text',
                    'rules' => ['nullable', 'max:255'],
                    'value' => null,
                ],
                'dark' => [
                    'type' => 'boolean',
                    'rules' => [],
                    'value' => true,
                ],
            ],
        ];
    }
}
