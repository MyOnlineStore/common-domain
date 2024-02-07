<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Arithmetic;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use Litipk\BigNumbers\Decimal;
use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

/** @psalm-immutable */
#[Embeddable]
final class Amount extends Number
{
    /** @var Decimal */
    #[Column(name: 'amount', type: 'bignumbers', options: ['doctrine_type' => 'bigint'])]
    protected $value;

    /**
     * @inheritDoc
     *
     * @throws InvalidArgument
     */
    public function __construct($value)
    {
        if (\str_contains((string)$value, '.')) {
            throw new InvalidArgument(\sprintf('Amount must be a whole number, "%s" given', $value));
        }

        parent::__construct($value ?? 0, 0);
    }

    public function toInt(): int
    {
        /** @psalm-suppress ImpureMethodCall */

        return $this->value->asInteger();
    }

    /** @psalm-pure */
    public static function asZero(): Amount
    {
        return new self(0);
    }
}
