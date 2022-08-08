<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Collection;

use MyOnlineStore\Common\Domain\Value\StoreId;

/**
 * @deprecated Should be moved to common-collection
 *
 * @extends ImmutableCollection<array-key, StoreId>
 */
final class StoreIds extends ImmutableCollection implements StoreIdsInterface
{
    use StringCollectionTrait;

    /**
     * @param StoreId[]|int[] $entries
     */
    public function __construct(array $entries = [])
    {
        parent::__construct(
            \array_map(
                static function ($entry) {
                    return $entry instanceof StoreId ? $entry : new StoreId($entry);
                },
                $entries
            )
        );
    }

    public function getRandom(): StoreId
    {
        if ($this->isEmpty()) {
            throw new \InvalidArgumentException('Can not select random element from empty collection');
        }

        return $this[\array_rand($this->toArray(), 1)];
    }

    /**
     * @inheritDoc
     */
    public function contains($element): bool
    {
        return \in_array($element, $this->getArrayCopy(), false);
    }

    public function unique(): StoreIdsInterface
    {
        return new self(\array_unique($this->toArray()));
    }
}
