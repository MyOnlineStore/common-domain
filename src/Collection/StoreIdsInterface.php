<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Collection;

use MyOnlineStore\Common\Domain\Value\StoreId;

/**
 * @method StoreId[] getIterator()
 */
interface StoreIdsInterface extends ImmutableCollectionInterface
{
    public function getRandom(): StoreId;

    public function unique(): StoreIdsInterface;
}
