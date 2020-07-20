<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Arithmetic;

use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

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
