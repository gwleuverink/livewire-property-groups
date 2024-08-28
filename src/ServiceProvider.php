<?php

namespace Leuverink\PropertyAttribute;

use Livewire\Component;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        // $this->registerGroupMacro();
    }

    public function register()
    {
        //
    }

    // Sadly Form objects are not macroable, going to use a trait instead
    // protected function registerGroupMacro()
    // {
    //     Component::macro($macro, function (string|array|null $groups = null): PropertyCollection {
    //         /** @var Component $this */
    //         return group($this, $groups);
    //     });
    // }
}
