<?php

namespace Dcodegroup\PageBuilder\Repositories;

use Dcodegroup\PageBuilder\Classes\Module;
use Illuminate\Support\Collection;

class ModuleRepository
{
    protected Collection $modules;

    public function __construct($modules)
    {
        $this->modules = collect(iterator_to_array($modules))
            ->mapWithKeys(function ($module) {
                $shortName = class_basename($module);
                return [$shortName => $module];
            });
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
                return [$key => $this->buildConfiguration($key)];
            });

        return $json ? json_encode($modules) : $modules;
    }

    public function buildConfiguration(string $key): array
    {
        $class = $this->findByName($key);

        /** @var Module $module */
        // TODO: this fails if we use app()->make(), not sure why.
        //   if we need the DI container, this is a must-fix
        $module = new $class();

        return [
            'name' => $module->name(),
            'icon' => $module->icon(),
            'className' => $class,
            'fields' => collect($module->fields())
                ->mapWithKeys(function ($field, $key) {
                    $fieldWithoutRules = collect($field)
                        ->filter(function ($_, $key) {
                            return $key !== 'rules';
                        });

                    return [$key => $fieldWithoutRules];
                })
                ->toArray(),
            'selected_template' => 'base',
            'templates' => [
                'base',
                ...$module->availableTemplates(),
            ],
        ];
    }
}
