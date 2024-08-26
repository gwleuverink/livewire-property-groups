<?php

use Tests\TestComponent;
use Leuverink\PropertyAttribute\Group;

use function Leuverink\PropertyAttribute\group;

it('returns multidimensional array if no methods where chained', function () {
    $component = new class extends TestComponent
    {
        #[Group('a')]
        public $foo = 1;
    };

    expect(group($component, 'a'))
        ->toBe([
            'foo' => 1,
        ]);
});

it('returns array keys when keys() method was chained', function () {
    $component = new class extends TestComponent
    {
        #[Group('a')]
        public $foo = 1;
    };

    expect(
        group($component, 'a')->keys()
    )
        ->toBe([
            'foo',
        ]);
});

it('returns array values when values() method was chained', function () {
    $component = new class extends TestComponent
    {
        #[Group('a')]
        public $foo = 1;
    };

    expect(
        group($component, 'a')->values()
    )
        ->toBe([
            1,
        ]);
});

it('has no unexpected side effects if both keys() and values() are called in the same chain', function () {
    $component = new class extends TestComponent
    {
        #[Group('a')]
        public $foo = 1;
    };

    expect(
        group($component, 'a')->keys()->values()
    )
        ->toBe([
            1,
        ]);
});

// Should be Integration tests? Component not mounted on unit level. Can't reset properties this way
it('resets all properties in a group when the reset() method was chained')->todo(); // add two groups for unhappy path
it('returns & resets all properties in a group when the pull() method was chained')->todo(); // add two groups for unhappy path
