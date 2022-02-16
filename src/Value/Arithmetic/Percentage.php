<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Arithmetic;

use Doctrine\ORM\Mapping as ORM;
use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

/**
 * @ORM\Embeddable
 *
 * @psalm-immutable
 */
final class Percentage extends Number
{
    private function __construct(string $value, ?int $scale = null)
    {
        parent::__construct($value, $scale);

        /** @psalm-suppress ImpureMethodCall */
        if ($this->value->isNegative() || $this->value->asInteger() > 100) {
            throw new InvalidArgument(\sprintf("Given value '%d' is not a valid percentage", $value));
        }
    }

    /**
     * @psalm-pure
     */
    public static function fromString(string $value, ?int $scale = null): self
    {
        return new self($value, $scale);
    }
}
