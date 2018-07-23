<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Collection;

use MyOnlineStore\Common\Domain\Value\RegionCode;

/**
 * @method RegionCode[] getIterator()
 */
interface RegionCodeCollectionInterface extends ImmutableCollectionInterface
{
    /**
     * @return string[]
     */
    public function asStrings();

    /**
     * @param string[] $isoCodes
     *
     * @return RegionCodeCollectionInterface
     */
    public static function fromStrings(array $isoCodes): RegionCodeCollectionInterface;

    /**
     * @return self
     */
    public function reindex();

    /**
     * @return RegionCodeCollectionInterface
     */
    public function unique(): RegionCodeCollectionInterface;
}
