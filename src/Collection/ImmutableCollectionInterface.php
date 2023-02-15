<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Collection;

/**
 * @template TKey of array-key
 * @template T
 * @extends \IteratorAggregate<TKey, T>
 * @extends \ArrayAccess<TKey, T>
 */
interface ImmutableCollectionInterface extends \ArrayAccess, \Countable, \IteratorAggregate
{
    /**
     * @param T $element
     *
     * @return bool
     */
    public function contains($element);

    /** @param callable(T): void $callback */
    public function each(callable $callback);

    /**
     * Returns if given collection is of the same type and has the same elements
     */
    public function equals(ImmutableCollectionInterface $otherCollection): bool;

    /** @return T|false */
    public function first();

    /**
     * @param T $element
     *
     * @return TKey|false Index van het gegeven element, of false wanneer deze niet voorkomt in de collectie
     */
    public function indexOf($element);

    /**
     * @return bool
     *
     * @psalm-assert-if-false T $this->first()
     * @psalm-assert-if-false T $this->last()
     */
    public function isEmpty();

    /**
     * Sets the internal iterator to the last element in the collection and returns this element.
     *
     * @return T|false
     */
    public function last();

    /** @return static */
    public function reindex();

    /** @return array<TKey, T> */
    public function toArray();
}
