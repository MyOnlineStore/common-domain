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
    /** @var string */
    private $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @throws \InvalidArgumentException
     */
    public static function fromString(string $value): self
    {
        if (!self::isValidHexColor($value)) {
            throw InvalidHexColor::withHexColor($value);
        }

        if (1 === \preg_match('/#([a-f0-9]{6})\b/i', $value)) {
            $value = \strtoupper($value);
        }

        if (1 === \preg_match('/#([a-f0-9]{3})\b/i', $value)) {
            $value = \strtoupper(
                \sprintf('#%s%s%s%s%s%s', $value[1], $value[1], $value[2], $value[2], $value[3], $value[3])
            );
        }

        return new self($value);
    }

    public function toString(): string
    {
        return $this->value;
    }

    private static function isValidHexColor(string $value): bool
    {
        if (1 === \preg_match('/#([a-f0-9]{6})\b/i', $value)) {
            return true;
        }

        return 1 === \preg_match('/#([a-f0-9]{3})\b/i', $value);
    }
}
