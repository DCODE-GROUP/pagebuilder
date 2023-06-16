<?php

namespace Dcodegroup\PageBuilder\Models;

use Dcodegroup\PageBuilder\Builders\MediaBuilder;
use Dcodegroup\PageBuilder\Routes;

class Media extends \Spatie\MediaLibrary\MediaCollections\Models\Media
{
    protected $appends = [
        'url',
    ];

    public function getUrlAttribute(): string
    {
        return route(Routes::front('media.get'), $this->id);
    }

    public function newEloquentBuilder($query): MediaBuilder
    {
        return new MediaBuilder($query);
    }
}
