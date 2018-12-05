<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Collection;

interface ImmutableCollectionInterface extends \Countable, \IteratorAggregate, \ArrayAccess
{
    /**
     * @param mixed $element
     *
     * @return bool
     */
    public function contains($element);

    /**
     * @param callable $callback
     */
    public function each(callable $callback);

    /**
     * Returns if given collection is of the same type and has the same elements
     *
     * @param ImmutableCollectionInterface $otherCollection
     *
     * @return bool
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

    /**
     * @return bool
     */
    public function isEmpty();

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
     * @return array
     */
    public function toArray();
}
