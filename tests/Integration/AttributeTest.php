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
            $this->result = $this->group('a');
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
            $this->result = $this->group('b');
        }
    })
        ->call('getGroupB')
        ->assertSet('result', [
            'bar' => 2,
            'baz' => 3,
        ]);
});

it('can retreive multiple groups at once', function () {
    Livewire::test(new class extends TestComponent
    {
        #[Group('a')]
        public $foo = 1;

        #[Group('b')]
        public $bar = 2;

        public ?array $result = [];

        public function getGroupB()
        {
            $this->result = $this->group(['a', 'b']);
        }
    })
        ->call('getGroupB')
        ->assertSet('result', [
            'foo' => 1,
            'bar' => 2,
        ]);
});
