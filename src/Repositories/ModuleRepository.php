<?php

namespace Dcodegroup\PageBuilder\Repositories;

use Dcodegroup\PageBuilder\Classes\Module;
use Illuminate\Support\Collection;

class ModuleRepository
{
    protected Collection $modules;

    public function __construct()
    {
        $this->modules = collect(config('page-builder.modules', []));
    }

    public function findByName(string $name)
    {
        return $this->modules->get($name);
    }

    public function getValues(): array
    {
        return $this->modules->values()->toArray();
    }

    public function getKeys(): array
    {
        return $this->modules->keys()->toArray();
    }

    public function buildConfigurations(bool $json = true): string|Collection
    {
        $modules = collect($this->getKeys())
            ->mapWithKeys(function (string $key) {
                /** @var Module $module */
                $class = $this->findByName($key);
                $module = new $class();
                return [$key => $module->configuration()];
            });

        return $json ? json_encode($modules) : $modules;
    }
}
