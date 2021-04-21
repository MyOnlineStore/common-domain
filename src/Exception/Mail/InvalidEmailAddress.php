<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Exception\Mail;

use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

/**
 * @psalm-immutable
 */
final class InvalidEmailAddress extends InvalidArgument
{
    public static function withEmailAddress(string $emailAddress): self
    {
        return new self(\sprintf('"%s" is not a valid email address', $emailAddress));
    }
}
