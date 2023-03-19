<?php

namespace Collections;

use ArrayAccess;
use Closure;
use Iterator;

class Collection implements ArrayAccess, Iterator
{
    private array $items;
    public int $length = 0;
    private int $position = 0;

    public function __construct(array $items = [])
    {
        $this->items = $items;
        $this->length = sizeof($items);
    }

    public function push(mixed $item)
    {
        $this->items[] = $item;
        $this->length ++;
    }

    public function pop(): mixed
    {
        if (empty($this->items)) {
            return null;
        }

        $lastItemPosition = $this->getLastPosition();
        $return =  $this->items[$lastItemPosition];
        unset($this->items[$lastItemPosition]);
        $this->length --;

        return $return;
    }

    public function shift(): mixed
    {
        if (empty($this->items)) {
            return null;
        }

        $firstPosition = $this->getFirstPosition();
        $return =  $this->items[$firstPosition];
        unset($this->items[$firstPosition]);
        $this->length --;

        return $return;
    }

    public function unshift(mixed $item)
    {
        array_unshift($this->items, $item);
        $this->length ++;
    }

    public function first()
    {
        if (empty($this->items)) {
            return null;
        }

        $firstPosition = $this->getFirstPosition();
        return $this->items[$firstPosition];
    }

    public function last()
    {
        if (empty($this->items)) {
            return null;
        }

        $lastItemPosition = $this->getLastPosition();
        return $this->items[$lastItemPosition];
    }

    private function getLastPosition(): mixed
    {
        return array_key_last($this->items);
    }

    private function getFirstPosition(): mixed
    {
        return array_key_first($this->items);
    }

    public function offsetExists(mixed $offset): bool
    {
        return array_key_exists($offset, $this->items);
    }

    public function offsetGet(mixed $offset): mixed
    {
        if (!$this->offsetExists($offset)) {
            return null;
        }
        return $this->items[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!array_key_exists($offset, $this->items)) {
            $this->length ++;
        }
        $this->items[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        if (!$this->offsetExists($offset)) {
            return;
        }

        unset($this->items[$offset]);
        $this->length --;
    }

    public function hasKey(mixed $key)
    {
        return $this->offsetExists($key);
    }

    public function current(): mixed
    {
        if (!$this->valid()) {
            return null;
        }
        return $this->items[$this->position];
    }

    public function next(): void
    {
        $this->position ++;
    }

    public function key(): mixed
    {
        return $this->position;
    }

    public function valid(): bool
    {
        if (empty($this->items)) {
            return false;
        }

        return isset($this->items[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function nextValue()
    {
        $this->next();
        return $this->current();
    }

    public function isEmpty() : bool
    {
        return count($this->items) == 0 ? true : false;
    }

    /**
     * @return bool
     */
    public function isNotEmpty() : bool
    {
        return count($this->items) > 0 ? true : false;
    }

    public function empty()
    {
        $this->items = [];
        $this->length = 0;
        return $this;
    }

    public function map($callback)
    {
        $result = array_map($callback, $this->items);
        $newCollection = new static($result);
        return $newCollection;
    }

    public function walk(Closure $function)
    {
        foreach ($this->items as $key => $item)
        {
            $this->items[$key] = $function($item);
        }
        return $this;
    }
}