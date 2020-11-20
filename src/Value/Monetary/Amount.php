<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Monetary;

use MyOnlineStore\Common\Domain\Exception\InvalidArgument;
use MyOnlineStore\Common\Domain\Value\Arithmetic\Number;

/**
 * @deprecated Use MyOnlineStore\Common\Domain\Value\Arithmetic\Amount instead
 *
 * @psalm-immutable
 */
final class Amount extends Number
{
    /**
     * @inheritDoc
     *
     * @throws InvalidArgument
     */
    public function __construct($value)
    {
        if (false !== \strpos((string) $value, '.')) {
            throw new InvalidArgument(\sprintf('Amount must be a whole number, "%s" given', $value));
        }

        parent::__construct($value, 0);
    }

    /**
     * @psalm-pure
     */
    public static function asZero(): Amount
    {
        return new self(0);
    }
}
