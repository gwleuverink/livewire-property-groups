# Livewire Property Groups

[![codestyle](https://github.com/gwleuverink/livewire-property-group/actions/workflows/codestyle.yml/badge.svg)](https://github.com/gwleuverink/livewire-property-group/actions/workflows/codestyle.yml)
[![tests](https://github.com/gwleuverink/livewire-property-group/actions/workflows/tests.yml/badge.svg)](https://github.com/gwleuverink/livewire-property-group/actions/workflows/tests.yml)

TODO: Short description

## Installation

```bash
composer require leuverink/livewire-property-group
```

## Usage

```php
class Form extends Component
    {
    #[Group('a')]
    public $foo = 1;
    #[Group('a')]
    public $bar = 2;

    #[Group('b')]
    public $baz = 3;


    public function submit()
    {
        $groupA = $this->group('a'); // ['foo' => 1, 'bar' => 2]
        $groupB = $this->group('b'); // ['baz' => 3]
    }
}
```

```php
// Behaves like a Collection
$this->group('a'); // returns all properties ['foo' => 1, 'bar' => 2]
$this->group('a')->keys(); // returns all property names ['foo', 'bar']
$this->group('a')->values(); // returns all property values [1, 2]
$this->group('a')->each(fn() => /* */); // iterate over properties

// Proxies Livewire calls
$this->group('a')->reset(); // resets properties to initial state
$this->group('a')->pull(); // returns all properties & resets properties to initial state
$this->group('a')->validate(); // validates all properties in a group

// Extra
$this->group(['a', 'b']); // operations can be applied to any number of groups
$this->group(['a', 'b'])->validate(); // especially handy when validating

```

## Development

```bash
composer lint # run all linters
composer fix # run all fixers

composer analyze # run static analysis
composer baseline # generate static analysis baseline
```

## License

This package is open-source software licensed under the MIT license.
