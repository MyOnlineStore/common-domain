<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Collection;

use MyOnlineStore\Common\Domain\Value\RegionCode;

/** @extends ImmutableCollectionInterface<array-key, RegionCode> */
interface RegionCodeCollectionInterface extends ImmutableCollectionInterface, StringCollectionInterface
{
    /** @return RegionCodeCollectionInterface */
    public function reindex();

    public function unique(): RegionCodeCollectionInterface;
}
