<?php

namespace Leuverink\PropertyAttribute;

use ReflectionClass;
use Livewire\Component;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->registerGroupMacro();
    }

    public function register()
    {
        //
    }

    protected function registerGroupMacro()
    {
        Component::macro('group', function (string|array $groups) {
            /** @var Component $this */
            $groups = (array) $groups;

            $result = [];
            $reflection = new ReflectionClass($this);
            $componentProperties = $reflection->getProperties();

            foreach ($groups as $group) {
                foreach ($componentProperties as $property) {
                    $attributes = $property->getAttributes(Group::class);

                    foreach ($attributes as $attribute) {
                        if ($attribute->getArguments()[0] === $group) {
                            $result[$property->getName()] = $property->getValue($this);
                            break;
                        }
                    }
                }
            }

            return $result;
            // TODO: Morgen verder
            // return new ChainableProxy($this, $name);
        });
    }
}
