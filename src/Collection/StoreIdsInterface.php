<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Collection;

use MyOnlineStore\Common\Domain\Value\StoreId;

/**
 * @method StoreId[] getIterator()
 *
 * @deprecated Should be moved to common-collection
 */
interface StoreIdsInterface extends ImmutableCollectionInterface
{
    /**
     * @throws \InvalidArgumentException
     */
    public function getRandom(): StoreId;

    public function unique(): StoreIdsInterface;
}
