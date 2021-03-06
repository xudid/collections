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

    public function testisEmpty()
    {
        $collection = new Collection([]);
        $this->assertTrue($collection->isEmpty());
        $colection2 = new Collection([1,2,3,4,5,6,7,8,9,0]);
        $this->assertFalse($colection2->isEmpty());
    }

    public function testisNotEmpty()
    {
        $collection = new Collection([]);
        $this->assertFalse($collection->isNotEmpty());
        $colection2 = new Collection([1,2,3,4,5,6,7,8,9,0]);
        $this->assertTrue($colection2->isNotEmpty());
    }

    public function testEmpty()
    {
        $colection = new Collection([1,2,3,4,5,6,7,8,9,0]);
        $result = $colection->empty();
        $this->assertTrue($colection->size() == 0);
        $this->assertTrue($colection->isEmpty());
        $this->assertFalse($colection->isNotEmpty());
        $this->assertInstanceOf(Collection::class, $result);
    }

    public function testCollactionAccessLikeArray()
    {
        $colection = new Collection([1,2,3,4,5,6,7,8,9,0]);
        $this->assertTrue($colection[0] == 1);
        $colection[0] = 2;
        $this->assertTrue($colection[0] == 2);
        unset($colection[0]);
        $this->assertFalse($colection[0] ==2);
    }

    public function testGet()
    {
        $colection = new Collection([1,2,3,4,5,6,7,8,9,0]);
        $result = $colection->get(0);
        $this->assertTrue($result == 1);
    }

    public function testWalk()
    {
        $function = function($value){
            var_dump($value);
            return $value * 2;
        };
        $collection = new Collection([]);
        $result = $collection->walk($function);
        $this->assertInstanceOf(Collection::class, $result);
        $collection2 = Collection::take([1, 2]);
        $collection2->walk($function);
        $this->assertTrue($collection2->get(0) == 2);
    }

}