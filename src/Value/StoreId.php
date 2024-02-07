<?php

namespace MyOnlineStore\Common\Domain\Value;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;

/** @psalm-immutable */
#[Embeddable]
final class StoreId
{
    /** @var int|string */
    #[Column(name: 'store_id', type: 'integer')]
    private $id;

    /** @param int|string $id */
    public function __construct($id)
    {
        if (!\is_numeric($id)) {
            throw new \InvalidArgumentException(\sprintf('Given ID "%s" is not numeric', $id));
        }

        $this->id = $id;
    }

    public function equals(self $storeId): bool
    {
        return (string) $this->id === (string) $storeId->id;
    }

    public function toString(): string
    {
        return (string) $this->id;
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
