<?php

namespace Leuverink\PropertyAttribute;

use ReflectionClass;
use Livewire\Component;

function group(Component $component, string|array|null $groups = null): PropertyCollection
{
    $groups = (array) $groups;

    $result = empty($groups)
        ? all_grouped_properties($component)
        : all_named_grouped_properties($component, $groups);

    return PropertyCollection::make($component, $result);
}

function all_grouped_properties(Component $component): array
{
    $result = [];
    $reflection = new ReflectionClass($component);
    $componentProperties = $reflection->getProperties();

    foreach ($componentProperties as $property) {
        $property->setAccessible(true); // Allows grabbing protected props in php < 8.1
        if ($property->getAttributes(Group::class)) {
            $result[$property->getName()] = $property->getValue($component);
        }
    }

    return $result;
}

function all_named_grouped_properties(Component $component, array $groups): array
{
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

    return $result;
}
