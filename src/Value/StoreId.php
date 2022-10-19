<?php

namespace MyOnlineStore\Common\Domain\Value;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 *
 * @psalm-immutable
 */
final class StoreId
{
    /**
     * @ORM\Column(name="store_id", type="integer")
     *
     * @var int|string
     */
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
