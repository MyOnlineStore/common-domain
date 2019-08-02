<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Collection;

class ImmutableCollection extends MutableCollection
{
    /**
     * @inheritDoc
     *
     * @throws \LogicException
     */
    public function add($element): void
    {
        throw new \LogicException(\sprintf('Method %s is not available on immutable collections', __FUNCTION__));
    }

    /**
     * @inheritDoc
     *
     * @throws \LogicException
     */
    public function offsetSet($index, $newval): void
    {
        throw new \LogicException(\sprintf('Method %s is not available on immutable collections', __FUNCTION__));
    }
}
