<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Collection;

/**
 * @template TKey of array-key
 * @template T
 * @implements MutableCollectionInterface<TKey, T>
 * @extends \ArrayObject<TKey, T>
 */
class MutableCollection extends \ArrayObject implements MutableCollectionInterface
{
    /** @param array<TKey,T> $entries */
    public function __construct(array $entries = [])
    {
        parent::__construct($entries);
    }

    /** @inheritDoc */
    public function add($element)
    {
        $this->append($element);
    }

    /** @inheritDoc */
    public function contains($element)
    {
        return \in_array($element, $this->getArrayCopy(), true);
    }

    /** @inheritDoc */
    public function each(callable $callback)
    {
        foreach ($this as $entry) {
            $callback($entry);
        }
    }

    public function equals(ImmutableCollectionInterface $otherCollection): bool
    {
        if (static::class !== $otherCollection::class) {
            return false;
        }

        if ($this->count() !== $otherCollection->count()) {
            return false;
        }

        foreach ($this as $entry) {
            if (!$otherCollection->contains($entry)) {
                return false;
            }
        }

        return true;
    }

    /** @inheritDoc */
    public function first()
    {
        $arrayCopy = $this->getArrayCopy();

        return \reset($arrayCopy);
    }

    /** @inheritDoc */
    public function indexOf($element)
    {
        return \array_search($element, $this->getArrayCopy(), true);
    }

    /** @inheritDoc */
    public function isEmpty()
    {
        return 0 === $this->count();
    }

    /** @inheritdoc */
    public function last()
    {
        $arrayCopy = $this->getArrayCopy();

        return \end($arrayCopy);
    }

    /** @inheritdoc */
    public function reindex()
    {
        return new static(\array_values($this->toArray()));
    }

    /** @inheritDoc */
    public function toArray()
    {
        return $this->getArrayCopy();
    }

    /** @param callable(T): bool $callback */
    protected function containsWith(callable $callback): bool
    {
        foreach ($this as $entry) {
            if ($callback($entry)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param \Closure(T): bool $closure
     *
     * @return static
     */
    protected function filter(\Closure $closure)
    {
        return new static(\array_filter($this->toArray(), $closure));
    }

    /**
     * @param callable(T): bool $callback
     *
     * @return T
     *
     * @throws \OutOfBoundsException
     */
    protected function firstHaving(callable $callback)
    {
        foreach ($this as $entry) {
            if ($callback($entry)) {
                return $entry;
            }
        }

        throw new \OutOfBoundsException('No entry found with given fallback');
    }

    /**
     * @param \Closure(T): T $closure
     *
     * @return static
     */
    protected function map(\Closure $closure)
    {
        return new static(\array_map($closure, $this->toArray()));
    }
}
