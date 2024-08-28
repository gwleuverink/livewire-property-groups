# Livewire Property Groups

[![codestyle](https://github.com/gwleuverink/livewire-property-groups/actions/workflows/codestyle.yml/badge.svg)](https://github.com/gwleuverink/livewire-property-groups/actions/workflows/codestyle.yml)
[![tests](https://github.com/gwleuverink/livewire-property-groups/actions/workflows/tests.yml/badge.svg)](https://github.com/gwleuverink/livewire-property-groups/actions/workflows/tests.yml)

This package simplifies property management, validation, and manipulation in Livewire components by allowing you to organize related properties into named groups.

## Installation

```bash
composer require leuverink/livewire-property-groups
```

## Basic Usage

```php
use Leuverink\PropertyAttribute\Group;
use Leuverink\PropertyAttribute\WithGroups;

class Form extends Component
{
    use WithGroups;

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

### Accessing Group Properties

Use the `WithGroups` trait within your Component or Form object to get access to the `group` method.

```php
// Get all properties in a group
$this->group('a'); // ['foo' => 1, 'bar' => 2]

// Get property names
$this->group('a')->keys(); // ['foo', 'bar']

// Get property values
$this->group('a')->values(); // [1, 2]

// Iterate over properties
$this->group('a')->each(fn() => /* */);

// Get all grouped properties, excluding non grouped
$this->group();

// Access group as an array or an object
$groupA = $this->group('a');
$groupA['foo'];
$groupA->foo;
```

### Proxying Livewire Methods

```php
// Reset properties to initial state
$this->group('a')->reset();

// Return all properties and reset to initial state
$this->group('a')->pull();

// Validate all properties in a group
$this->group('a')->validate();
```

### Working with Multiple Groups

```php
// Retrieve properties from multiple groups
$this->group(['a', 'b']);

// Validate multiple groups
$this->group(['a', 'b'])->validate();
```

### Debugging

```php
// dump group properties
$this->group('a')->dump();

// dd group properties
$this->group('a')->dd();

// dump is chainable
$validated = $this->group('a')
    ->dump()
    ->validate();
```

### Conflicting `group` method signature

I realize that `group` is a very generic method name that you might well use inside your own components.
You may change the macro's signature by providing an alias.

```php
use WithGroups {
    group as fooBar;
}
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
