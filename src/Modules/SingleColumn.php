<?php

namespace Dcodegroup\PageBuilder\Modules;

use Dcodegroup\PageBuilder\Classes\Module;

class SingleColumn extends Module
{
    protected string $name = 'Single column';
    protected string $icon = 'file-alt';

    public function fields(): array
    {
        return [
            'sub_heading' => [
                'type' => 'text',
                'rules' => ['nullable', 'max:255'],
                'value' => null,
            ],
            'heading' => [
                'type' => 'text',
                'rules' => ['required', 'max:255'],
                'value' => null,
            ],
            'body' => [
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
