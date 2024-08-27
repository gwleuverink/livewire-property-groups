<?php

namespace Leuverink\PropertyAttribute;

use ReflectionClass;
use Livewire\Component;

function group(Component $component, string|array|null $groups = null): PropertyCollection
{
    $groups = (array) $groups;

    $result = [];
    $reflection = new ReflectionClass($component);
    $componentProperties = $reflection->getProperties();

    // No groups given, return all grouped properties
    if (empty($groups)) {
        foreach ($componentProperties as $property) {
            $property->setAccessible(true); // Allows grabbing protected props in php < 8.1
            if ($property->getAttributes(Group::class)) {
                $result[$property->getName()] = $property->getValue($component);
            }
        }

        return PropertyCollection::make($component, $result);
    }

    // Return properties for given groups
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

function getGroupedProperties(): array {}
