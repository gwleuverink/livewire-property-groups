<?php

namespace Tests;

use Livewire\Form;
use Livewire\Attributes\Validate;
use Leuverink\PropertyAttribute\Group;
use Leuverink\PropertyAttribute\WithGroups;

class TestForm extends Form
{
    use WithGroups;

    #[Group('a')]
    #[Validate('string')]
    public $foo = 1;

    #[Group('b')]
    #[Validate('string')]
    public $bar = 2;
}
