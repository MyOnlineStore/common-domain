<?php

namespace MyOnlineStore\Common\Domain\Value;

use Doctrine\ORM\Mapping as ORM;
use MyOnlineStore\Common\Domain\Assertion\NumericAssertionTrait;

/**
 * @ORM\Embeddable
 */
class StoreId
{
    use NumericAssertionTrait;

    /**
     * @ORM\Column(name="store_id", type="integer")
     *
     * @var int|string
     */
    private $id;

    /**
     * @param int $id
     */
    public function __construct($id)
    {
        if (!$this->assertIsNumeric($id)) {
            throw new \InvalidArgumentException(sprintf('Given ID "%s" is not numeric', $id));
        }

        $this->id = $id;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->id;
    }

    /**
     * @param StoreId $storeId
     *
     * @return bool
     */
    public function equals(StoreId $storeId)
    {
        return $this == $storeId;
    }
}
