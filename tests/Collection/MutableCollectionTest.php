<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Collection;

use MyOnlineStore\Common\Domain\Collection\ImmutableCollection;
use MyOnlineStore\Common\Domain\Collection\MutableCollection;

final class MutableCollectionTest extends \PHPUnit\Framework\TestCase
{
    public function testAdd()
    {
        $collection = new MutableCollection(['foo', 'bar']);
        $collection->add('baz');

        self::assertSame(['foo', 'bar', 'baz'], $collection->toArray());
    }

    public function testContains()
    {
        $collection = new MutableCollection(['foo', 'bar']);

        self::assertTrue($collection->contains('bar'));
        self::assertFalse($collection->contains('baz'));
    }

    public function testContainsWithWillReturnCorrectElements()
    {
        $reflection = new \ReflectionClass(MutableCollection::class);
        $containsWith = $reflection->getMethod('containsWith');
        $containsWith->setAccessible(true);

        $collection = new MutableCollection([new \Exception('foo'), new \Exception('bar')]);

        self::assertTrue(
            $containsWith->invokeArgs(
                $collection,
                [
                    function (\Exception $exception) {
                        return 'foo' === $exception->getMessage();
                    },
                ]
            )
        );

        self::assertFalse(
            $containsWith->invokeArgs(
                $collection,
                [
                    function (\Exception $exception) {
                        return 'qux' === $exception->getMessage();
                    },
                ]
            )
        );
    }

    public function testEachWillCallFunctionOnEachElement()
    {
        $itemA = $this->createMock(\Iterator::class);
        $itemA->expects(self::once())->method('next');

        $itemB = $this->createMock(\Iterator::class);
        $itemB->expects(self::once())->method('next');

        $test = new MutableCollection([$itemA, $itemB]);

        $test->each(
            function (\Iterator $item) {
                $item->next();
            }
        );
    }

    public function testEqualsWillReturnTrueIfCollectionsAreOfTheSameTypeAndContainsTheSameElements()
    {
        $element1 = new \stdClass();
        $element2 = new \stdClass();
        $collection = new MutableCollection([$element1, $element2]);

        self::assertTrue($collection->equals(new MutableCollection([$element1, $element2])));

        // same elements in different order
        self::assertTrue($collection->equals(new MutableCollection([$element2, $element1])));

        // different collection type
        self::assertFalse($collection->equals(new ImmutableCollection([$element1, $element2])));

        // missing element 2
        self::assertFalse($collection->equals(new MutableCollection([$element1])));
    }

    public function testFilterWillReturnCorrectElements()
    {
        $element1 = $this->getMockBuilder(\stdClass::class)->setMethods(['isFoobar'])->getMock();
        $element2 = $this->getMockBuilder(\stdClass::class)->setMethods(['isFoobar'])->getMock();

        $element1->expects(self::once())->method('isFoobar')->willReturn(false);
        $element2->expects(self::once())->method('isFoobar')->willReturn(true);

        $extendedClass = new class([$element1, $element2]) extends MutableCollection
        {
            /**
             * @param \Closure $closure
             *
             * @return static
             */
            public function filter(\Closure $closure)
            {
                return parent::filter($closure);
            }
        };

        self::assertEquals(
            [1 => $element2],
            $extendedClass->filter(
                function (\stdClass $element) {
                    return $element->isFoobar();
                }
            )->toArray()
        );
    }

    public function testFirst()
    {
        $collection = new MutableCollection(['foo', 'bar']);

        self::assertSame('foo', $collection->first());
    }

    public function testFirstHavingWillReturnCorrectElements()
    {
        $element1 = $this->getMockBuilder(\stdClass::class)->setMethods(['isFoobar'])->getMock();
        $element2 = $this->getMockBuilder(\stdClass::class)->setMethods(['isFoobar'])->getMock();

        $element1->expects(self::once())->method('isFoobar')->willReturn(false);
        $element2->expects(self::once())->method('isFoobar')->willReturn(true);

        $extendedClass = new class([$element1, $element2]) extends MutableCollection
        {
            /**
             * @param callable $callback
             *
             * @return static
             *
             * @throws \OutOfBoundsException
             */
            public function firstHaving(callable $callback)
            {
                return parent::firstHaving($callback);
            }
        };

        self::assertSame(
            $element2,
            $extendedClass->firstHaving(
                function (\stdClass $element) {
                    return $element->isFoobar();
                }
            )
        );
    }

    public function testFirstHavingWithNoResultWillThrowException()
    {
        $element1 = $this->getMockBuilder(\stdClass::class)->setMethods(['isFoobar'])->getMock();

        $element1->expects(self::once())->method('isFoobar')->willReturn(false);

        $extendedClass = new class([$element1]) extends MutableCollection
        {
            /**
             * @param callable $callback
             *
             * @return static
             *
             * @throws \OutOfBoundsException
             */
            public function firstHaving(callable $callback)
            {
                return parent::firstHaving($callback);
            }
        };

        $this->expectException(\OutOfBoundsException::class);

        $extendedClass->firstHaving(
            function (\stdClass $element) {
                return $element->isFoobar();
            }
        );
    }

    public function testIndexOf()
    {
        $collection = new MutableCollection(['foo', 'bar']);

        self::assertSame(0, $collection->indexOf('foo'));
        self::assertSame(1, $collection->indexOf('bar'));
    }

    public function testIsEmpty()
    {
        self::assertTrue((new MutableCollection())->isEmpty());
        self::assertFalse((new MutableCollection(['foo']))->isEmpty());
        self::assertFalse((new MutableCollection([null]))->isEmpty());
    }

    public function testLastWillReturnLastElementInArray()
    {
        $test = new MutableCollection([1, 2, 3]);

        self::assertSame(3, $test->last());
    }

    public function testMapWillMapCorrectElements()
    {
        $element1 = $this->createMock(\stdClass::class);
        $element2 = $this->createMock(\stdClass::class);

        $extendedClass = new class([$element1, $element2]) extends MutableCollection
        {
            /**
             * @param \Closure $closure
             *
             * @return static
             */
            public function map(\Closure $closure)
            {
                return parent::map($closure);
            }
        };

        self::assertSame(
            [$element1, $element2],
            $extendedClass->map(
                function (\stdClass $element) {
                    return $element;
                }
            )->toArray()
        );
    }

    public function testReindexWillReturnReindexedArray()
    {
        $test = new MutableCollection([1 => 1, 3 => 2, 666 => 3]);

        self::assertEquals([1, 2, 3], $test->reindex()->toArray());
    }
}
