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

it('returns array keys when keys() method was chained')->todo();
it('returns array values when values() method was chained')->todo();
it('has no unexpected side effects if both keys() and values() are called in the same chain')->todo();
it('resets all properties in a group when the reset() method was chained')->todo(); // add two groups for unhappy path
it('returns & resets all properties in a group when the pull() method was chained')->todo(); // add two groups for unhappy path
