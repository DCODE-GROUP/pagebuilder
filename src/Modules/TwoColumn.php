<?php

namespace Dcodegroup\PageBuilder\Modules;

use Dcodegroup\PageBuilder\Module;

class TwoColumn extends Module
{
    protected string $name = 'Two column';

    protected string $icon = 'columns';

    public function fields(): array
    {
        return [
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
        ];
    }
}
