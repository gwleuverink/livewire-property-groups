<?php

namespace Leuverink\PropertyAttribute;

trait WithGroups
{
    public function group(string|array|null $groups = null)
    {
        return group($this, $groups);
    }
}
