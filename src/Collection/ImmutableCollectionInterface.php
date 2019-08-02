<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Collection;

interface ImmutableCollectionInterface extends \Countable, \IteratorAggregate, \ArrayAccess
{
    /**
     * @param mixed $element
     */
    public function contains($element): bool;

    public function each(callable $callback): void;

    /**
     * Returns if given collection is of the same type and has the same elements
     */
    public function equals(ImmutableCollectionInterface $otherCollection): bool;

    /**
     * @return mixed
     */
    public function first();

    /**
     * @param mixed $element
     *
     * @return mixed Index van het gegeven element, of false wanneer deze niet voorkomt in de collectie
     */
    public function indexOf($element);

    public function isEmpty(): bool;

    /**
     * Sets the internal iterator to the last element in the collection and returns this element.
     *
     * @return mixed
     */
    public function last();

    /**
     * @return static
     */
    public function reindex();

    /**
     * @return mixed[]
     */
    public function toArray(): array;
}
