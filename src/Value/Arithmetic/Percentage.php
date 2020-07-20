<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Arithmetic;

use Doctrine\ORM\Mapping as ORM;
use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

/**
 * @ORM\Embeddable
 */
final class Percentage extends Number
{
    /**
     * @inheritdoc
     */
    public function __construct(int $value, int $scale = null)
    {
        parent::__construct((string) $value, $scale);

        if ($this->value->isNegative() || $this->value->asInteger() > 100) {
            throw new InvalidArgument(sprintf("Given value '%d' is not a valid percentage", $value));
        }
    }
}
