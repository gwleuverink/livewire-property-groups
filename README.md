# Livewire Property Groups

[![codestyle](https://github.com/gwleuverink/livewire-property-group/actions/workflows/codestyle.yml/badge.svg)](https://github.com/gwleuverink/livewire-property-group/actions/workflows/codestyle.yml)
[![tests](https://github.com/gwleuverink/livewire-property-group/actions/workflows/tests.yml/badge.svg)](https://github.com/gwleuverink/livewire-property-group/actions/workflows/tests.yml)

This package simplifies property management, validation, and manipulation in Livewire components by allowing you to organize related properties into named groups.

## Installation

```bash
composer require leuverink/livewire-property-group
```

## Basic Usage

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

## Accessing Group Properties

```php
// Get all properties in a group
$this->group('a'); // ['foo' => 1, 'bar' => 2]

// Get property names
$this->group('a')->keys(); // ['foo', 'bar']

// Get property values
$this->group('a')->values(); // [1, 2]

// Iterate over properties
$this->group('a')->each(fn() => /* */);
```

## Proxying Livewire Methods

```php
// Reset properties to initial state
$this->group('a')->reset();

// Return all properties and reset to initial state
$this->group('a')->pull();

// Validate all properties in a group
$this->group('a')->validate();
```

## Working with Multiple Groups

```php
// Perform operations on multiple groups
$this->group(['a', 'b']);

// Validate multiple groups
$this->group(['a', 'b'])->validate();
```

## Debugging

```php
// Dump group properties
$this->group('a')->dump();

// dd group properties
$this->group('a')->dd();

// Dump is chainable
$validated = $this->group('a')
    ->dump()
    ->validate();
```

<br />
<hr />
<br />

## Development

```bash
composer lint # run all linters
composer fix # run all fixers

composer analyze # run static analysis
composer baseline # generate static analysis baseline
```

## License

This package is open-source software licensed under the MIT license.
