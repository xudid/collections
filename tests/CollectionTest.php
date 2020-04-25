<?php

use Codeception\Test\Unit;
use Collections\Collection;

class CollectionTest extends Unit
{

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testCollectionTakeEmptyArray()
    {
        $collection = Collection::take([]);
        $this->assertInstanceOf(Collections\Collection::class, $collection);
    }
}