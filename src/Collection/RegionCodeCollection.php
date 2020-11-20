<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Collection;

use MyOnlineStore\Common\Domain\Value\RegionCode;

/**
 * @deprecated Should be moved to common-collection
 */
final class RegionCodeCollection extends ImmutableCollection implements RegionCodeCollectionInterface
{
    use StringCollectionTrait;

    /**
     * @inheritdoc
     */
    public function __construct(array $entries = [])
    {
        parent::__construct(
            \array_filter(
                $entries,
                static function ($entry) {
                    return $entry instanceof RegionCode;
                }
            )
        );
    }

    /**
     * @inheritDoc
     */
    public function contains($element): bool
    {
        return \in_array($element, $this->getArrayCopy());
    }

    public function unique(): RegionCodeCollectionInterface
    {
        return new self(\array_unique($this->toArray()));
    }

    /**
     * @param string[] $isoCodes
     */
    public static function fromStrings(array $isoCodes): RegionCodeCollectionInterface
    {
        return new self(
            \array_map(
                static function ($isoCode) {
                    return new RegionCode($isoCode);
                },
                $isoCodes
            )
        );
    }
}
