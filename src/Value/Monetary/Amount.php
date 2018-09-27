<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Monetary;

use MyOnlineStore\Common\Domain\Value\Arithmetic\Number;

final class Amount extends Number
{
    /**
     * @inheritDoc
     */
    public function __construct($value)
    {
        if (false !== \strpos((string) $value, '.')) {
            throw new \InvalidArgumentException(
                sprintf('Amount must be a whole number, "%s" given', $value)
            );
        }

        parent::__construct($value, 0);
    }

    /**
     * @return Amount
     */
    public static function asZero(): Amount
    {
        return new self(0);
    }
}
