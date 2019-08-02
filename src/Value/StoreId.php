<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
final class StoreId
{
    /**
     * @ORM\Column(name="store_id", type="integer")
     *
     * @var int
     */
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }

    public function equals(self $storeId): bool
    {
        return $this->id === $storeId->id;
    }
}
