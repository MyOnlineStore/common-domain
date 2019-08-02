<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Collection;

class MutableCollection extends \ArrayObject implements MutableCollectionInterface
{
    /**
     * @inheritDoc
     */
    public function add($element): void
    {
        $this[] = $element;
    }

    /**
     * @inheritDoc
     */
    public function contains($element): bool
    {
        return \in_array($element, $this->getArrayCopy(), true);
    }

    public function each(callable $callback): void
    {
        foreach ($this as $entry) {
            $callback($entry);
        }
    }

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
        return \reset($this);
    }

    /**
     * @inheritDoc
     */
    public function indexOf($element)
    {
        return \array_search($element, $this->getArrayCopy(), true);
    }

    public function isEmpty(): bool
    {
        return 0 === $this->count();
    }

    /**
     * @inheritdoc
     */
    public function last()
    {
        return \end($this);
    }

    /**
     * @inheritdoc
     */
    public function reindex()
    {
        return new static(\array_values($this->toArray()));
    }

    /**
     * @return mixed[]
     */
    public function toArray(): array
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
