<?php

namespace Dcodegroup\PageBuilder\Modules;

use Dcodegroup\PageBuilder\Module;

class Heading extends Module
{
    protected string $name = 'Heading';
    protected string $icon = 'heading';

    public function fields(): array
    {
        return [
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
        ];
    }
}
