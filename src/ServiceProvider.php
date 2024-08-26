<?php

namespace Leuverink\PropertyAttribute;

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
        Component::macro('group', function (string|array $groups): PropertyCollection {
            /** @var Component $this */
            return group($this, $groups);
        });
    }
}
