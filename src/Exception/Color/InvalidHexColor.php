<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Exception\Color;

use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

/** @psalm-immutable */
final class InvalidHexColor extends InvalidArgument
{
    /** @psalm-pure */
    public static function withHexColor(string $color, \Throwable|null $previous = null): self
    {
        return new self(
            \sprintf(
                'The hexadecimal value "%s" is invalid, requires a # sign and 6 or 3 characters',
                $color,
            ),
            0,
            $previous,
        );
    }
}
