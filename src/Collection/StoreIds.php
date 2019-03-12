<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Collection;

use MyOnlineStore\Common\Domain\Value\StoreId;

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
                function ($entry) {
                    return ($entry instanceof StoreId) ? $entry : new StoreId($entry);
                },
                $entries
            )
        );
    }

    public function getRandom(): StoreId
    {
        return $this[\array_rand($this->toArray(), 1)];
    }

    public function contains($element): bool
    {
        return \in_array($element, $this->getArrayCopy(), false);
    }

    public function unique(): StoreIdsInterface
    {
        return new self(\array_unique($this->toArray()));
    }
}
