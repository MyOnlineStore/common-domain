<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Color;

use MyOnlineStore\Common\Domain\Exception\Color\InvalidHexColor;

/**
 * @final
 * @psalm-immutable
 */
class HexColor
{
    private function __construct(
        private string $value
    ) {
    }

    /**
     * @throws \InvalidArgumentException
     */
    public static function fromString(string $value): self
    {
        if (!self::isValidHexColor($value)) {
            throw InvalidHexColor::withHexColor($value);
        }

        if (4 === \strlen($value)) {
            $value = \sprintf('#%s%s%s%s%s%s', $value[1], $value[1], $value[2], $value[2], $value[3], $value[3]);
        }

        return new self(\strtoupper($value));
    }

    public function toString(): string
    {
        return $this->value;
    }

    private static function isValidHexColor(string $value): bool
    {
        return 1 === \preg_match('/^#[a-f0-9]{3}$|^#[a-f0-9]{6}$/i', $value);
    }
}
