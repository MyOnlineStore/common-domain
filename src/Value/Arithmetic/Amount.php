<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Arithmetic;

use Doctrine\ORM\Mapping as ORM;
use Litipk\BigNumbers\Decimal;
use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

/**
 * @ORM\Embeddable
 *
 * @psalm-immutable
 */
final class Amount extends Number
{
    /**
     * @ORM\Column(name="amount", type="bignumbers", options={"doctrine_type"="bigint"})
     *
     * @var Decimal
     */
    protected $value;

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
