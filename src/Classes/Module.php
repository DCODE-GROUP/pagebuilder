<?php

namespace Dcodegroup\PageBuilder\Classes;

use Illuminate\Support\Str;

abstract class Module
{
    abstract public function configuration(): array;

    public function viewName(): string
    {
        // NOTE: use static instead of self because of inheritance
        return 'page-builder::modules.' . Str::slug(class_basename(static::class));
    }

    public function availableTemplates(): array
    {
        return [];
    }
}
