<?php

namespace Leuverink\PropertyAttribute;

use Livewire\Form;
use ReflectionClass;
use Livewire\Component;

function group(Component|Form $component, string|array|null $groups = null): PropertyCollection
{
    $groups = (array) $groups;

    $result = empty($groups)
        ? all_groups($component)
        : named_groups($component, $groups);

    return PropertyCollection::make($component, $result);
}

function all_groups(Component|Form $component): array
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

function named_groups(Component|Form $component, array $groups): array
{
    $result = [];
    $reflection = new ReflectionClass($component);
    $componentProperties = $reflection->getProperties();

    foreach ($groups as $group) {

        foreach ($componentProperties as $property) {

            $property->setAccessible(true); // Allows grabbing protected props in php < 8.1
            $attributes = $property->getAttributes(\Leuverink\PropertyAttribute\Group::class);

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
