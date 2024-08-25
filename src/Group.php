<?php

namespace Leuverink\PropertyAttribute;

use Attribute;
use Livewire\Features\SupportAttributes\Attribute as LivewireAttribute;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_PROPERTY)]
class Group extends LivewireAttribute
{
    public function __construct(
        public string $name
    ) {}
}
