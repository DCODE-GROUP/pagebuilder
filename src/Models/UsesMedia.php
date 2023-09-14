<?php

namespace Dcodegroup\PageBuilder\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

abstract class UsesMedia extends Model implements HasMedia
{
    use InteractsWithMedia;

    public function parentModel(): MorphMany
    {
        return $this->morphMany(config('media-library.media_model'), 'parent_model');
    }

    public function registerMediaConversions(\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(config('page-builder.media.conversions.thumb.width'))
            ->height(config('page-builder.media.conversions.thumb.height'))
            ->sharpen(10);

        $this->addMediaConversion('list')
            ->width(config('page-builder.media.conversions.list.width'))
            ->height(config('page-builder.media.conversions.list.height'))
            ->sharpen(10);

        $this->addMediaConversion('grid')
            ->width(config('page-builder.media.conversions.grid.width'))
            ->height(config('page-builder.media.conversions.grid.height'))
            ->sharpen(10);
    }
}
