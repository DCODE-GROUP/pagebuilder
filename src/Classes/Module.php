<?php

namespace Dcodegroup\PageBuilder\Classes;

use Illuminate\Support\Str;

abstract class Module
{
    protected string $name;
    protected string $icon;

    abstract public function fields(): array;

    public function viewName(string $selectedTemplate = 'base'): string
    {
        // NOTE: use static instead of self because of inheritance
        return 'page-builder::modules.' . Str::kebab(class_basename(static::class)) . '.' . $selectedTemplate;
    }

    public function availableTemplates(): array
    {
        return [];
    }

    public function name(): string
    {
        return $this->name;
    }

    public function icon(): string
    {
        return $this->icon;
    }
}
