<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Exception\Tax;

use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

/**
 * @psalm-immutable
 */
final class InvalidVatNumber extends InvalidArgument
{
    public static function withVatNumber(string $vatNumber): self
    {
        return new self(\sprintf('"%s" is not a valid vat number', $vatNumber));
    }
}
