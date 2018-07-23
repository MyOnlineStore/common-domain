<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Collection;

use MyOnlineStore\Common\Domain\Collection\ArrayCollection;
use MyOnlineStore\Common\Domain\Collection\ImmutableCollection;

final class ArrayCollectionTest extends \PHPUnit\Framework\TestCase
{
    public function testEachWillCallFunctionOnEachElement()
    {
        $element = $this->getMockBuilder(\stdClass::class)
            ->setMethods(['test'])
            ->getMock();

        $collection = new ArrayCollection([$element]);

        $element->expects(self::once())->method('test')->with('foobar');

        $collection->each(
            function (\stdClass $element) {
                $element->test('foobar');
            }
        );
    }

    public function testEqualsWillConvertToMutableCollectionsAndCheckEquality()
    {
        $element1 = new \stdClass();
        $element2 = new \stdClass();
        $collection = new ArrayCollection([$element1, $element2]);

        self::assertTrue($collection->equals(new ArrayCollection([$element1, $element2])));

        // same elements in different order
        self::assertTrue($collection->equals(new ArrayCollection([$element2, $element1])));

        // different collection type
        self::assertFalse($collection->equals(new ImmutableCollection([$element1, $element2])));

        // missing element 2
        self::assertFalse($collection->equals(new ArrayCollection([$element1])));
    }

    public function testReindexWillReturnReindexedArray()
    {
        $test = new ArrayCollection([1 => 1, 3 => 2, 666 => 3]);

        self::assertEquals([1, 2, 3], $test->reindex()->toArray());
    }
}
