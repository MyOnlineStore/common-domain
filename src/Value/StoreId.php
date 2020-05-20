<?php

namespace MyOnlineStore\Common\Domain\Value;

use Doctrine\ORM\Mapping as ORM;
use MyOnlineStore\Common\Domain\Assertion\NumericAssertionTrait;

/**
 * @deprecated Should be removed from common-domain
 *
 * @ORM\Embeddable
 */
final class StoreId
{
    use NumericAssertionTrait;

    /**
     * @ORM\Column(name="store_id", type="integer")
     *
     * @var int|string
     */
    private $id;

    /**
     * @param int|string $id
     */
    public function __construct($id)
    {
        if (!$this->assertIsNumeric($id)) {
            throw new \InvalidArgumentException(\sprintf('Given ID "%s" is not numeric', $id));
        }

        $this->id = $id;
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }

    public function equals(self $storeId): bool
    {
        return (string) $this->id === (string) $storeId->id;
    }
}
