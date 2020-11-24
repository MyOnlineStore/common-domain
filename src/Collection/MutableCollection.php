<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Collection;

/**
 * @deprecated Should be moved to common-collection
 */
class MutableCollection extends \ArrayObject implements MutableCollectionInterface
{
    /**
     * @param array $entries
     */
    public function __construct(array $entries = [])
    {
        parent::__construct($entries);
    }

    /**
     * @inheritDoc
     *
     * @return void
     */
    public function add($element)
    {
        $this[] = $element;
    }

    /**
     * @inheritDoc
     */
    public function contains($element)
    {
        return \in_array($element, $this->getArrayCopy(), true);
    }

    /**
     * @inheritDoc 
     *
     * @return void
     */
    public function each(callable $callback)
    {
        foreach ($this as $entry) {
            $callback($entry);
        }
    }

    /**
     * @inheritDoc
     */
    public function equals(ImmutableCollectionInterface $otherCollection): bool
    {
        if (static::class !== \get_class($otherCollection)) {
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

    /**
     * @inheritDoc
     */
    public function first()
    {
        $arrayCopy = $this->getArrayCopy();

        return \reset($arrayCopy);
    }

    /**
     * @inheritDoc
     */
    public function indexOf($element)
    {
        return \array_search($element, $this->getArrayCopy(), true);
    }

    /**
     * @inheritDoc
     */
    public function isEmpty()
    {
        return 0 === $this->count();
    }

    /**
     * @inheritdoc
     */
    public function last()
    {
        $arrayCopy = $this->getArrayCopy();

        return \end($arrayCopy);
    }

    /**
     * @inheritdoc
     */
    public function reindex()
    {
        return new static(\array_values($this->toArray()));
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return $this->getArrayCopy();
    }

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
     * @return static
     */
    protected function filter(\Closure $closure)
    {
        return new static(\array_filter($this->toArray(), $closure));
    }

    /**
     * @return mixed
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
     * @return static
     */
    protected function map(\Closure $closure)
    {
        return new static(\array_map($closure, $this->toArray()));
    }
}
