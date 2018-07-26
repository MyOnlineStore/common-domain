<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Collection;

use MyOnlineStore\Common\Domain\Value\RegionCode;
use MyOnlineStore\Domain\Collection\StringCollectionInterface;

/**
 * @method RegionCode[] getIterator()
 */
interface RegionCodeCollectionInterface extends ImmutableCollectionInterface, StringCollectionInterface
{
    /**
     * @return RegionCodeCollectionInterface
     */
    public function reindex(): RegionCodeCollectionInterface;

    /**
     * @return RegionCodeCollectionInterface
     */
    public function unique(): RegionCodeCollectionInterface;
}
