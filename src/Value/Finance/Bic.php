<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Finance;

use IsoCodes\SwiftBic;
use MyOnlineStore\Common\Domain\Exception\Finance\InvalidBic;

/**
 * @final
 * @psalm-immutable
 */
class Bic
{
    private function __construct(
        private string $bic
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function fromString(string $bic): self
    {
        $bic = \strtoupper($bic);

        /** @psalm-suppress ImpureMethodCall */
        if (!SwiftBic::validate($bic)) {
            throw InvalidBic::withBic($bic);
        }

        return new self($bic);
    }

    public function equals(self $other): bool
    {
        return $this->bic === $other->bic;
    }

    public function toString(): string
    {
        return $this->bic;
    }
}
