<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Collection;

/**
 * @template TKey of array-key
 * @template T
 */
trait StringCollectionTrait
{
    /** @return array<TKey, string> */
    public function asStrings(): array
    {
        return \array_map('strval', $this->toArray());
    }

    /** @return array<TKey, T> */
    abstract public function toArray();
}
