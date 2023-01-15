<?php

namespace Dcodegroup\PageBuilder\Repositories;

class ModuleRepository
{
    protected array $modules;

    public function __construct() {
        $this->modules = config('page-builder.modules');
    }

    public function findByName(string $name)
    {
        foreach($this->modules as $key => $module) {
            if ($key === $name) {
                return $module;
            }
        }

        return false;
    }

    public function getValues()
    {
        return array_values($this->modules);
    }

    public function getKeys()
    {
        return array_keys($this->modules);
    }
}