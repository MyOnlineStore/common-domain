<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value;

use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

/**
 * ISO 639 code (https://en.wikipedia.org/wiki/ISO_639)
 *
 * @psalm-immutable
 */
final class LanguageCode
{
    private function __construct(
        private string $code
    ) {
    }

    /**
     * @throws InvalidArgument
     *
     * @psalm-pure
     */
    public static function fromString(string $code): self
    {
        if (!\preg_match('/^[a-z]{2,3}$/i', $code)) {
            throw new InvalidArgument(\sprintf('Invalid language code given: %s', $code));
        }

        return new self(\strtolower($code));
    }

    public function equals(self $other): bool
    {
        return $this->code === $other->code;
    }

    public function toString(): string
    {
        return $this->code;
    }
}
