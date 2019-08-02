<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Monetary;

use Litipk\BigNumbers\Decimal;
use MyOnlineStore\Common\Domain\Value\Arithmetic\Number;

final class Amount extends Number
{
    /**
     * @param int|string|float|Number|Decimal $value
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($value)
    {
        if (false !== \strpos((string) $value, '.')) {
            throw new \InvalidArgumentException(
                \sprintf('Amount must be a whole number, "%s" given', $value)
            );
        }

        parent::__construct($value, 0);
    }

    public static function asZero(): Amount
    {
        return new self(0);
    }
}
