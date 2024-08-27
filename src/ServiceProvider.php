<?php

namespace Leuverink\PropertyAttribute;

use Livewire\Component;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        // Only when using locally
        if (! $this->app->environment(['local', 'testing'])) {

            $this->publishes([
                __DIR__ . '/../config/property-group.php' => config_path('property-group.php'),
            ], 'livewire-property-group');
        }

        $this->registerGroupMacro();
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/property-group.php', 'property-group');
    }

    protected function registerGroupMacro()
    {
        $macro = config('property-group.macro');
        $macro = str($macro)->camel()->toString();

        Component::macro($macro, function (string|array|null $groups = null): PropertyCollection {
            /** @var Component $this */
            return group($this, $groups);
        });
    }
}
