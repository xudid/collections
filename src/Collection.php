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
     * @param array $array
     * @return static
     */
    public static function take(array $array)
    {
        return new static($array);
    }

    public function size()
    {
        return count($this->array);
    }
}