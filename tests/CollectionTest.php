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
    public function testCollectionTakeArray()
    {
        $collection = Collection::take([]);
        $this->assertInstanceOf(Collections\Collection::class, $collection);
    }

    public function testSize()
    {
        $collection = new Collection([]);
        $this->assertEquals(0, $collection->size());
        $colection2 = new Collection([1,2,3,4,5,6,7,8,9,0]);
        $this->assertEquals(10, $colection2->size());
    }
}