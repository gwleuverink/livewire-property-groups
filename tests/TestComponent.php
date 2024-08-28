<?php

namespace Tests;

use Livewire\Component;
use Leuverink\PropertyAttribute\WithGroups;

class TestComponent extends Component
{
    use WithGroups;

    public function render()
    {
        return '<div></div>';
    }
}
