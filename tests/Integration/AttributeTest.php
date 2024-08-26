<?php

use Livewire\Livewire;
use Tests\TestComponent;
use Leuverink\PropertyAttribute\Group;

it('groups properties', function () {
    Livewire::test(new class extends TestComponent
    {
        #[Group('a')]
        public $foo = 1;
        #[Group('a')]
        public $bar = 2;

        #[Group('b')]
        public $baz = 3;

        public ?array $result = [];

        public function getGroupA()
        {
            $this->result = $this->group('a')->toArray();
        }
    })
        ->call('getGroupA')
        ->assertSet('result', [
            'foo' => 1,
            'bar' => 2,
        ]);
});

it('supports shared groups', function () {
    Livewire::test(new class extends TestComponent
    {
        #[Group('a')]
        public $foo = 1;

        #[Group('a')]
        #[Group('b')]
        public $bar = 2;

        #[Group('b')]
        public $baz = 3;

        public ?array $result = [];

        public function getGroupB()
        {
            $this->result = $this->group('b')->toArray();
        }
    })
        ->call('getGroupB')
        ->assertSet('result', [
            'bar' => 2,
            'baz' => 3,
        ]);
});

it('can retrieve multiple groups at once', function () {
    Livewire::test(new class extends TestComponent
    {
        #[Group('a')]
        public $foo = 1;

        #[Group('b')]
        public $bar = 2;

        public ?array $result = [];

        public function getGroupB()
        {
            $this->result = $this->group(['a', 'b'])->toArray();
        }
    })
        ->call('getGroupB')
        ->assertSet('result', [
            'foo' => 1,
            'bar' => 2,
        ]);
});

it('resets all properties in a group when the `reset` method was chained', function () {
    Livewire::test(new class extends TestComponent
    {
        #[Group('a')]
        public $foo = 1;

        #[Group('b')]
        public $bar = 2;

        public ?array $result = [];

        public function resetGroupA()
        {
            $this->group('a')->reset();
        }
    })
        ->set([
            'foo' => 'faa',
            'bar' => 'baa',
        ])
        ->call('resetGroupA')
        ->assertSet('foo', 1)
        ->assertSet('bar', 'baa');
});

it('returns & resets all properties in a group when the `pull` method was chained', function () {
    Livewire::test(new class extends TestComponent
    {
        #[Group('a')]
        public $foo = 1;

        #[Group('b')]
        public $bar = 2;

        public ?array $result = [];

        public function pullGroupA()
        {
            $this->result = $this->group('a')->pull();
        }
    })
        ->set([
            'foo' => 'faa',
            'bar' => 'baa',
        ])
        ->call('pullGroupA')
        ->assertSet('foo', 1)
        ->assertSet('bar', 'baa')
        ->assertSet('result', ['foo' => 'faa']);
});

it('validates all properties in a group when the `validate` method was chained')->todo(); // add two groups for unhappy path
