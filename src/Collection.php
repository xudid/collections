<?php


namespace Collections;


use ArrayAccess;
use Closure;

class Collection implements ArrayAccess
{
    protected array $array;

    /**
     * Collection constructor.
     * @param array $array
     */
    public function __construct(array $array)
    {
        $this->array = $array;
    }


    /**
     * Create a collection with an array
     * @param array $array
     * @return static
     */
    public static function take(array $array)
    {
        return new static($array);
    }

    /**
     * @return int return collection size
     */
    public function size() : int
    {
        return count($this->array);
    }

    /**
     * @return bool
     */
    public function isEmpty() : bool
    {
        return count($this->array) == 0 ? true : false;
    }

    /**
     * @return bool
     */
    public function isNotEmpty() : bool
    {
        return count($this->array) > 0 ? true : false;
    }


    /**
     * @return Collection
     */
    public function empty()
    {
        $this->array = [];
        return $this;
    }

    /**
     * @param Closure $function
     * @return Collection
     */
    public function walk(Closure $function)
    {
        foreach ($this->array as $key => $item)
        {
            $this->array[$key] = $function($item);
        }
        return $this;
    }


    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->array);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            return $this->array[$offset];
        }
        return false;
    }

    /**
     * @param $offset
     * @return bool|mixed
     */
    public function get($offset)
    {
        return $this->offsetGet($offset);
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        $this->array[$offset] = $value;
    }

    /**
     * @param $offset
     * @param $value
     * @return Collection
     */
    public function set($offset, $value)
    {
        $this->array[$offset] = $value;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            unset($this->array[$offset]);
        }
    }
}
