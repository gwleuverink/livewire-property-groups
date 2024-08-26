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
        ->toHaveKey('foo')
        ->toContain(1);
});

it('returns array keys when `keys` method was chained', function () {
    $component = new class extends TestComponent
    {
        #[Group('a')]
        public $foo = 1;
    };

    expect(group($component, 'a'))
        ->keys()
        ->toBeArray()
        ->toContain('foo');
});

it('returns array values when `values` method was chained', function () {
    $component = new class extends TestComponent
    {
        #[Group('a')]
        public $foo = 1;
    };

    expect(group($component, 'a'))
        ->values()
        ->toBeArray()
        ->toContain(1);
});

it('can iterate over properties in a group when the `each` method was chained', function () {
    $component = new class extends TestComponent
    {
        #[Group('a')]
        public $foo = 1;

        #[Group('a')]
        public $bar = 2;
    };

    $iterations = 0;

    group($component, 'a')->each(fn () => $iterations++);

    expect($iterations)->toBe(2);
});

it('can chain on the `each` method', function () {
    $component = new class extends TestComponent
    {
        #[Group('a')]
        public $foo = 1;

        #[Group('a')]
        public $bar = 2;
    };

    expect(group($component, 'a'))
        ->each(function () {
            // Don't have to do anything here
        })
        ->values()
        ->toBeArray()
        ->toContain(1, 2);
});

it('can transform PropertyCollection to a array', function () {
    $component = new class extends TestComponent
    {
        #[Group('a')]
        public $foo = 1;
    };

    $result = group($component, 'a')->toArray();

    expect($result)->toBeArray();
});

// Should be Integration tests? Component not mounted on unit level. Can't reset properties this way
it('resets all properties in a group when the `reset` method was chained')->todo(); // add two groups for unhappy path
it('returns & resets all properties in a group when the `pull` method was chained')->todo(); // add two groups for unhappy path
it('validates all properties in a group when the `validate` method was chained')->todo(); // add two groups for unhappy path
