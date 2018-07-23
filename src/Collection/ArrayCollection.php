<?php

namespace MyOnlineStore\Common\Domain\Collection;

/**
 * @deprecated Use MyOnlineStore\Domain\Collection\MutableCollection instead!
 */
class ArrayCollection extends \Doctrine\Common\Collections\ArrayCollection implements MutableCollectionInterface
{
    /**
     * @inheritDoc
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
        if (\get_class($this) !== \get_class($otherCollection)) {
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
     * @inheritdoc
     */
    public function reindex()
    {
        return new static(array_values($this->toArray()));
    }
}
