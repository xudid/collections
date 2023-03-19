<?php

use Collections\Collection;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testNewCollectionIsEmptyByDefault()
    {
        $collection = new Collection;
        $this->assertNotNull($collection->length);
        $this->assertEquals(0, $collection->length);
    }

    public function testCollectionImplementsArrayAccessInterface()
    {
        $collection = new Collection;
        $this->assertInstanceOf(ArrayAccess::class, $collection);
    }

    public function testAccessItemByKeyReturnValueWithNonEmptyCollectionLikeArray()
    {
        $collection = new Collection([1]);
        $item = $collection[0];
        $this->assertEquals(1, $item);

        $collection = new Collection(['key' => 1]);
        $item = $collection['key'];
        $this->assertEquals(1, $item);
    }

    public function testSetItemWithKeyAssignValueLikeArray()
    {
        $collection = new Collection([1]);
        $collection['key'] = 3;
        $this->assertEquals(2, $collection->length);
        $item = $collection['key'];
        $this->assertEquals(3, $item);
        $collection['key'] = 4;
        $this->assertEquals(2, $collection->length);
        $item = $collection['key'];
        $this->assertEquals(4, $item);
    }

    public function testUnsetLikeArray()
    {
        $collection = new Collection([1]);
        unset($collection[0]);
        $this->assertEquals(0, $collection->length);
        unset($collection[0]);
        $this->assertEquals(0, $collection->length);
    }

    public function testKeyExistsInCollection()
    {
        $collection = new Collection(['key' => 1]);
        $result = $collection->hasKey('key');
        $this->assertTrue($result);
    }

    public function testCollectionAccessLikeArray()
    {
        $collection = new Collection([1,2,3,4,5,6,7,8,9,0]);
        $this->assertTrue($collection[0] == 1);
        $collection[0] = 2;
        $this->assertTrue($collection[0] == 2);
        unset($collection[0]);
        $this->assertTrue($collection[0] == null);
    }

    public function testCollectionImplementsIterator()
    {
        $collection = new Collection;
        $this->assertInstanceOf(Iterator::class, $collection);
    }

    public function testNewEmptyCollectionCurrentPositionIs0()
    {
        $collection = new Collection;
        $initialPosition = $collection->key();
        $this->assertEquals(0, $initialPosition);
    }

    public function testCollectionPositionIncreaseByOneAfterNext()
    {
        $collection = new Collection([1]);
        $initialPosition = $collection->key();
        $collection->next();
        $nextPosition = $collection->key();
        $this->assertEquals($initialPosition + 1, $nextPosition);
    }

    public function testEmptyCollectionValidReturnFalse()
    {
        $collection = new Collection;
        $result = $collection->valid();
        $this->assertFalse($result);
    }

    public function testNewNotEmptyCollectionValidReturnTrue()
    {
        $collection = new Collection([1]);
        $result = $collection->valid();
        $this->assertTrue($result);
    }

    public function testCurrentPostionAfterRewindIs0()
    {
        $collection = new Collection([1]);
        $collection->next();
        $collection->rewind();
        $currentPostion = $collection->key();
        $this->assertEquals(0, $currentPostion);
    }

    public function testCurrentOnEmptyCollectionReturnNull()
    {
        $collection = new Collection;
        $result = $collection->current();
        $this->assertNull($result);
    }

    public function testCurrentOnCollectionReturnGoodValue()
    {
        $collection = new Collection([1,2,3]);
        $result = $collection->current();
        $this->assertEquals(1, $result);
        $collection->next();
        $result = $collection->current();
        $this->assertEquals(2, $result);
        $collection->next();
        $result = $collection->current();
        $this->assertEquals(3, $result);
        $collection->next();
        $result = $collection->current();
        $this->assertEquals(null, $result);
    }

    public function testAfterForeachOnCollectionPositionEqualsElementCount()
    {
        $baseArray = [1, 2, 3];
        $elementCount = count($baseArray);

        $collection = new Collection($baseArray);
        foreach ($collection as $item) {
            continue;
        }
        $currentPosition = $collection->key();
        $this->assertEquals($elementCount, $currentPosition);
    }

    public function testNextValueReturnNullWithEmptyCollection()
    {
        $collection = new Collection;
        $result = $collection->nextValue();
        $this->assertNull($result);
    }

    public function testNextValueOnCollectionReturnGoodValue()
    {
        $collection = new Collection([1,2,3]);
        $result = $collection->nextValue();
        $this->assertEquals(2, $result);
        $result = $collection->nextValue();
        $this->assertEquals(3, $result);
        $result = $collection->nextValue();
        $this->assertEquals(null, $result);
    }

    public function testNewCollectionInitWithAnArrayOfOneElementHasLength1()
    {
        $collection = new Collection([1]);
        $this->assertEquals(1, $collection->length);
        $collection = new Collection(['key' => 1]);
        $this->assertEquals(1, $collection->length);
    }

    public function testFirstReturnFirstElementAndLengthDoesntChange()
    {
        $collection = new Collection([1]);
        $result = $collection->first();
        $this->assertEquals(1, $collection->length);
        $this->assertEquals(1, $result);
        $collection = new Collection([2, 1]);
        $result = $collection->first();
        $this->assertEquals(2, $collection->length);
        $this->assertEquals(2, $result);

        $collection = new Collection(['first' => 2, 'second' => 1]);
        $result = $collection->first();
        $this->assertEquals(2, $collection->length);
        $this->assertEquals(2, $result);
    }

    public function testLastReturnLastElementAndLengthDoesntChange()
    {
        $collection = new Collection([1]);
        $result = $collection->last();
        $this->assertEquals(1, $collection->length);
        $this->assertEquals(1, $result);
        $collection = new Collection([1, 2]);
        $result = $collection->last();
        $this->assertEquals(2, $collection->length);
        $this->assertEquals(2, $result);

        $collection = new Collection(['first' => 2, 'second' => 1]);
        $result = $collection->last();
        $this->assertEquals(1, $result);
    }

    public function testPushOneElementIncreaseLengthByOne()
    {
        $collection = new Collection;
        $this->assertEquals(0, $collection->length);
        $collection->push(1);
        $this->assertEquals(1, $collection->length);
        $collection->push('A');
        $this->assertEquals(2, $collection->length);
        $collection->push(new StdClass);
        $this->assertEquals(3, $collection->length);
        $collection->push(new StdClass, 'object');
        $this->assertEquals(4, $collection->length);

        $collection = new Collection(['key' => 'A']);
        $collection->push(new StdClass);
        $this->assertEquals(2, $collection->length);

    }

    public function testPushAddElementAtTheEnd()
    {
        $collection = new Collection([2, 4]);
        $collection->push(1);
        $lastItem = $collection->last();
        $this->assertEquals(1, $lastItem);

        $collection = new Collection(['key' => 'A']);
        $collection->push(1);
        $lastItem = $collection->last();
        $this->assertEquals(1, $lastItem);
    }

    public function testPopElementDecreaseLengthByOne()
    {
        $collection = new Collection([1]);
        $collection->pop();
        $this->assertEquals(0, $collection->length);

        $collection = new Collection(['key' => 'A']);
        $collection->pop();
        $this->assertEquals(0, $collection->length);

    }

    public function testPopEmptyCollectionLengthStayTo0()
    {
        $collection = new Collection;
        $collection->pop();
        $this->assertEquals(0, $collection->length);

        $collection = new Collection(['key' => 'A']);
        $collection->pop();
        $collection->pop();
        $collection->pop();
        $this->assertEquals(0, $collection->length);
    }

    public function testPopEmptyCollectionReturnNull()
    {
        $collection = new Collection;
        $result = $collection->pop();
        $this->assertNull($result);
    }

    public function testPopRemoveElementAtTheEnd()
    {
        $collection = new Collection([2, 4]);
        $lastItem = $collection->last();
        $poppedItem = $collection->pop();
        $this->assertEquals($lastItem, $poppedItem);
        $lastItem = $collection->last();
        $poppedItem = $collection->pop();
        $this->assertEquals($lastItem, $poppedItem);

        $collection = new Collection(['first' => 2, 'second' => 1]);
        $lastItem = $collection->last();
        $poppedItem = $collection->pop();
        $this->assertEquals($lastItem, $poppedItem);
        $lastItem = $collection->last();
        $poppedItem = $collection->pop();
        $this->assertEquals($lastItem, $poppedItem);

    }

    public function testShiftElementDecreaseLengthByOne()
    {
        $collection = new Collection([1]);
        $collection->shift();
        $this->assertEquals(0, $collection->length);

        $collection = new Collection(['first' => 2, 'second' => 1]);
        $collection->shift();
        $this->assertEquals(1, $collection->length);

    }

    public function testShiftEmptyCollectionLengthStayTo0()
    {
        $collection = new Collection;
        $collection->shift();
        $this->assertEquals(0, $collection->length);
    }

    public function testShiftEmptyCollectionReturnNull()
    {
        $collection = new Collection;
        $result = $collection->shift();
        $this->assertNull($result);
    }

    public function testShiftElementRemoveItAtStart()
    {
        $collection = new Collection([1, 2]);
        $firstItem = $collection->first();
        $shiftedItem = $collection->shift();
        $this->assertEquals($firstItem, $shiftedItem);
        $firstItem = $collection->first();
        $shiftedItem = $collection->shift();
        $this->assertEquals($firstItem, $shiftedItem);

        $collection = new Collection(['first' => 2, 'second' => 1]);
        $firstItem = $collection->first();
        $shiftedItem = $collection->shift();
        $this->assertEquals($firstItem, $shiftedItem);
    }

    public function testUnshiftIncreaseLengthByOne()
    {
        $collection = new Collection;
        $this->assertEquals(0, $collection->length);
        $collection->unshift(1);
        $this->assertEquals(1, $collection->length);
        $collection->unshift('A');
        $this->assertEquals(2, $collection->length);
        $collection->unshift(new StdClass);
        $this->assertEquals(3, $collection->length);

        $collection = new Collection(['first' => 2, 'second' => 1]);
        $collection->unshift(1);
        $this->assertEquals(3, $collection->length);

    }

    public function testUnshiftAddElementAtStart()
    {
        $collection = new Collection([1, 2]);
        $collection->unshift(3);
        $firstItem = $collection->first();
        $this->assertEquals(3, $firstItem);

        $collection = new Collection(['first' => 2, 'second' => 1]);
        $collection->unshift(1);
        $firstItem = $collection->first();
        $this->assertEquals(1, $firstItem);
    }

    public function testMapCollectionReturnAnotherCollection()
    {
        $collection = new Collection;
        $collection2 = $collection->map(fn() => '');
        $this->assertInstanceOf(Collection::class, $collection2);
        $this->assertNotSame($collection, $collection2);
    }

    public function testMapApplyFunctionOnCollectionElements()
    {
        $collection = new Collection([1]);
        $function = fn($x) => $x + 1;
        $collection2 = $collection->map($function);
        $firstItem = $collection2->first();
        $this->assertEquals(2, $firstItem);
    }

    // tests
    public function testLength()
    {
        $collection = new Collection([]);
        $this->assertEquals(0, $collection->length);
        $colection2 = new Collection([1,2,3,4,5,6,7,8,9,0]);
        $this->assertEquals(10, $colection2->length);
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
        $this->assertTrue($colection->length == 0);
        $this->assertTrue($colection->isEmpty());
        $this->assertFalse($colection->isNotEmpty());
        $this->assertInstanceOf(Collection::class, $result);
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
        $collection2 = new Collection([1, 2]);
        $collection2->walk($function);
        $this->assertTrue($collection2[0] == 2);
    }

}