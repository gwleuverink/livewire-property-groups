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

        public array $result = [];

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

test('supports shared groups', function () {
    Livewire::test(new class extends TestComponent
    {
        #[Group('a')]
        public $foo = 1;

        #[Group('a')]
        #[Group('b')]
        public $bar = 2;

        #[Group('b')]
        public $baz = 3;

        public array $result = [];

        public function getGroupA()
        {
            $this->result = $this->group('a');
        }
    })
        ->call('getGroupA')
        ->assertSet('result', [
            'bar' => 1,
            'baz' => 2,
        ]);
});
