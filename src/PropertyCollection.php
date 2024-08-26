<?php

namespace Leuverink\PropertyAttribute;

use Iterator;
use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;
use Livewire\Component;

class PropertyCollection implements ArrayAccess, IteratorAggregate
{
    final public function __construct(
        private readonly Component $component,
        private array $items = []
    ) {}

    public static function make(Component $component, $items = [])
    {
        return new static($component, (array) $items);
    }

    /*
    |--------------------------------------------------------------------------
    | Collection methods
    |--------------------------------------------------------------------------
    */
    public function toArray(): array
    {
        return $this->items;
    }

    public function keys(): array
    {
        return array_keys($this->items);
    }

    public function values(): array
    {
        return array_values($this->items);
    }

    public function each(callable $callback): self
    {
        foreach ($this as $key => $item) {
            if ($callback($item, $key) === false) {
                break;
            }
        }

        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Livewire Proxy methods
    |--------------------------------------------------------------------------
    */
    public function reset()
    {
        return $this->component->reset(
            $this->keys()
        );
    }

    public function pull()
    {
        return $this->component->pull(
            $this->keys()
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ArrayAccess/Iterator methods
    |--------------------------------------------------------------------------
    */
    public function offsetExists($offset): bool
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet($offset): mixed
    {
        return $this->items[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->items[] = $value;

            return;
        }

        $this->items[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->items[$offset]);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
    }
}
