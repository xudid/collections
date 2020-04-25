<?php


namespace Collections;


class Collection
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
     * @return $this
     */
    public function empty()
    {
        $this->array = [];
        return $this;
    }
}
