<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Collection;

use MyOnlineStore\Common\Domain\Value\RegionCode;

/**
 * @method RegionCode[] getIterator()
 */
interface RegionCodeCollectionInterface extends ImmutableCollectionInterface, StringCollectionInterface
{
    /**
     * @return static
     */
    public function reindex();

    public function unique(): RegionCodeCollectionInterface;
}
