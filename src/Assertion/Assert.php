<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Assertion;

use MyOnlineStore\Common\Domain\Exception\InvalidArgument;
use Webmozart\Assert\Assert as WebmozartAssert;

/** @psalm-immutable */
final class Assert extends WebmozartAssert
{
    /**
     * @inheritDoc
     *
     * @throws InvalidArgument
     *
     * @psalm-pure
     */
    protected static function reportInvalidArgument($message): void
    {
        throw new InvalidArgument($message);
    }
}
