<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Exception\Contact;

use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

/**
 * @psalm-immutable
 */
final class InvalidPhoneNumber extends InvalidArgument
{
    /**
     * @psalm-pure
     */
    public static function withPhoneNumber(string $bic, ?\Throwable $previous = null): self
    {
        return new self(\sprintf('The phone number "%s" is invalid', $bic), 0, $previous);
    }
}
