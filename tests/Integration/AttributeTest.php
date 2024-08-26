<?php

use Livewire\Livewire;
use Tests\TestComponent;
use Livewire\Attributes\Validate;
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

it('retrieves multiple groups at once', function () {
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

it('supports livewire reset forwarding', function () {
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

it('supports livewire pull forwarding', function () {
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

it('supports livewire validate forwarding', function () {
    Livewire::test(new class extends TestComponent
    {
        #[Group('a')]
        #[Validate('integer')]
        public $foo = 1;

        #[Group('b')]
        #[Validate('integer')]
        public $bar = 2;

        public function validateGroupA()
        {
            $this->group('a')->validate();
        }
    })
        ->set([
            'foo' => 'faa', // should fail
            'bar' => 'baa', // should fail, but not validate
        ])
        ->call('validateGroupA')
        ->assertHasErrors('foo')
        ->assertHasNoErrors('bar');
});

it('returns only validated properties in a group', function () {
    Livewire::test(new class extends TestComponent
    {
        #[Group('a')]
        #[Validate('string')]
        public $foo = 1;

        #[Group('b')]
        #[Validate('integer')]
        public $bar = 2;

        public ?array $result = [];

        public function validateGroupA()
        {
            $this->result = $this->group('a')->validate();
        }
    })
        ->set([
            'foo' => 'faa', // should fail
            'bar' => 'baa', // should fail, but not validate
        ])
        ->call('validateGroupA')
        ->assertHasNoErrors('bar')
        ->assertSet('result', ['foo' => 'faa']);
});
