<?php

use Tests\TestComponent;
use Leuverink\PropertyAttribute\Group;
use Leuverink\PropertyAttribute\PropertyCollection;

use function Leuverink\PropertyAttribute\group;

it('returns PropertyCollection', function () {
    $component = new class extends TestComponent
    {
        #[Group('a')]
        public $foo = 1;
    };

    expect(group($component, 'a'))
        ->toBeInstanceOf(PropertyCollection::class);
});

it('ensures PropertyCollection is Iterable & ArrayAccessable', function () {
    $component = new class extends TestComponent
    {
        #[Group('a')]
        public $foo = 1;
    };

    expect(group($component, 'a'))
        ->toBeIterable()
        ->toHaveKey('foo')
        ->toContain(1);

});

it('can access property collection like a object', function () {
    $component = new class extends TestComponent
    {
        #[Group('a')]
        public $foo = 1;
    };

    expect(group($component, 'a'))
        ->foo->toBe(1);
});

it('returns null when a property not found', function () {
    $component = new class extends TestComponent
    {
        #[Group('a')]
        public $foo = 1;
    };

    expect(group($component, 'a'))
        ->bar->toBe(null);
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

    group($component, 'a')->each(function () use (&$iterations) {
        $iterations++;
    });

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

    $result = group($component, 'a')
        ->each(function () {
            // Don't have to do anything here
        });

    expect($result)
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

it('wont crash when Attribute is not applied in component', function () {
    $component = new class extends TestComponent {};

    $result = group($component, 'a')->toArray();

    expect($result)->toBeEmpty();
});

arch('it is dumpable')
    ->expect(PropertyCollection::class)
    ->toHaveMethod('dump')
    ->toHaveMethod('dd');
