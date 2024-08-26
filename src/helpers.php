<?php

namespace Leuverink\PropertyAttribute;

use ReflectionClass;
use Livewire\Component;

function group(Component $component, string|array $groups): PropertyCollection
{
    $groups = (array) $groups;

    $result = [];
    $reflection = new ReflectionClass($component);
    $componentProperties = $reflection->getProperties();

    foreach ($groups as $group) {
        foreach ($componentProperties as $property) {
            $property->setAccessible(true); // Allows grabbing protected props in php < 8.1
            $attributes = $property->getAttributes(Group::class);

            foreach ($attributes as $attribute) {
                if ($attribute->getArguments()[0] === $group) {
                    $result[$property->getName()] = $property->getValue($component);
                    break;
                }
            }
        }
    }

    return PropertyCollection::make($component, $result);
}
