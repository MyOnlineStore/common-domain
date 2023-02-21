<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Collection;

use MyOnlineStore\Common\Domain\Collection\ImmutableCollection;
use MyOnlineStore\Common\Domain\Collection\MutableCollection;
use PHPUnit\Framework\TestCase;

final class MutableCollectionTest extends TestCase
{
    public function testAdd(): void
    {
        $collection = new MutableCollection(['foo', 'bar']);
        $collection->add('baz');

        self::assertSame(['foo', 'bar', 'baz'], $collection->toArray());
    }

    public function testContains(): void
    {
        $collection = new MutableCollection(['foo', 'bar']);

        self::assertTrue($collection->contains('bar'));
        self::assertFalse($collection->contains('baz'));
    }

    public function testContainsWithWillReturnCorrectElements(): void
    {
        $reflection = new \ReflectionClass(MutableCollection::class);
        $containsWith = $reflection->getMethod('containsWith');

        $collection = new MutableCollection([new \Exception('foo'), new \Exception('bar')]);

        self::assertTrue(
            $containsWith->invokeArgs(
                $collection,
                [
                    static fn (\Throwable $exception) => 'foo' === $exception->getMessage(),
                ],
            ),
        );

        self::assertFalse(
            $containsWith->invokeArgs(
                $collection,
                [
                    static fn (\Throwable $exception) => 'qux' === $exception->getMessage(),
                ],
            ),
        );
    }

    public function testEachWillCallFunctionOnEachElement(): void
    {
        $itemA = $this->createMock(\Iterator::class);
        $itemA->expects(self::once())->method('next');

        $itemB = $this->createMock(\Iterator::class);
        $itemB->expects(self::once())->method('next');

        $test = new MutableCollection([$itemA, $itemB]);

        $test->each(
            static function (\Iterator $item): void {
                $item->next();
            },
        );
    }

    public function testEqualsWillReturnTrueIfCollectionsAreOfTheSameTypeAndContainsTheSameElements(): void
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

    public function testFilterWillReturnCorrectElements(): void
    {
        $element1 = new \stdClass();
        $element1->fooBar = false;
        $element2 = new \stdClass();
        $element2->fooBar = true;

        $extendedClass = new class ([$element1, $element2]) extends MutableCollection {
            /** @return static */
            public function filter(\Closure $closure): static
            {
                return parent::filter($closure);
            }
        };

        self::assertEquals(
            [1 => $element2],
            $extendedClass->filter(
                static fn (\stdClass $element): bool => (bool) $element->fooBar,
            )->toArray(),
        );
    }

    public function testFirst(): void
    {
        $collection = new MutableCollection(['foo', 'bar']);

        self::assertSame('foo', $collection->first());
    }

    public function testFirstHavingWillReturnCorrectElements(): void
    {
        $element1 = new \stdClass();
        $element1->fooBar = false;
        $element2 = new \stdClass();
        $element2->fooBar = true;

        $extendedClass = new class ([$element1, $element2]) extends MutableCollection {
            /** @throws \OutOfBoundsException */
            public function firstHaving(callable $callback): \stdClass
            {
                return parent::firstHaving($callback);
            }
        };

        self::assertSame(
            $element2,
            $extendedClass->firstHaving(
                static fn (\stdClass $element): bool => (bool) $element->fooBar,
            ),
        );
    }

    public function testFirstHavingWithNoResultWillThrowException(): void
    {
        $element1 = new \stdClass();
        $element1->fooBar = false;

        $extendedClass = new class ([$element1]) extends MutableCollection {
            /**
             * @return static
             *
             * @throws \OutOfBoundsException
             */
            public function firstHaving(callable $callback): static
            {
                return parent::firstHaving($callback);
            }
        };

        $this->expectException(\OutOfBoundsException::class);

        $extendedClass->firstHaving(
            static fn (\stdClass $element): bool => (bool) $element->fooBar,
        );
    }

    public function testIndexOf(): void
    {
        $collection = new MutableCollection(['foo', 'bar']);

        self::assertSame(0, $collection->indexOf('foo'));
        self::assertSame(1, $collection->indexOf('bar'));
    }

    public function testIsEmpty(): void
    {
        self::assertTrue((new MutableCollection())->isEmpty());
        self::assertFalse((new MutableCollection(['foo']))->isEmpty());
        self::assertFalse((new MutableCollection([null]))->isEmpty());
    }

    public function testLastWillReturnLastElementInArray(): void
    {
        $test = new MutableCollection([1, 2, 3]);

        self::assertSame(3, $test->last());
    }

    public function testMapWillMapCorrectElements(): void
    {
        $element1 = $this->createMock(\stdClass::class);
        $element2 = $this->createMock(\stdClass::class);

        $extendedClass = new class ([$element1, $element2]) extends MutableCollection {
            /** @return static */
            public function map(\Closure $closure): static
            {
                return parent::map($closure);
            }
        };

        self::assertSame(
            [$element1, $element2],
            $extendedClass->map(
                static fn (\stdClass $element) => $element,
            )->toArray(),
        );
    }

    public function testReindexWillReturnReindexedArray(): void
    {
        $test = new MutableCollection([1 => 1, 3 => 2, 666 => 3]);

        self::assertEquals([1, 2, 3], $test->reindex()->toArray());
    }
}
