<?php

namespace Dcodegroup\PageBuilder\Modules;

use Dcodegroup\PageBuilder\Module;

class Video extends Module
{
    protected string $name = 'Video';

    protected string $icon = 'video';

    public function fields(): array
    {
        return [
            'videoId' => [
                'type' => 'text',
                'rules' => ['required', 'max:255'],
                'value' => null,
            ],
        ];
    }
}
