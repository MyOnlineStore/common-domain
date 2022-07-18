<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Collection;

/**
 * @deprecated Should be moved to common-collection
 */
class ImmutableCollection extends MutableCollection
{
    /**
     * @inheritDoc
     *
     * @return void
     */
    public function add($element)
    {
        throw new \LogicException(\sprintf('Method %s is not available on immutable collections', __FUNCTION__));
    }

    public function offsetSet(mixed $key, mixed $value): void
    {
        throw new \LogicException(\sprintf('Method %s is not available on immutable collections', __FUNCTION__));
    }
}
