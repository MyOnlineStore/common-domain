<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Finance;

use IsoCodes\SwiftBic;
use MyOnlineStore\Common\Domain\Exception\Finance\InvalidBic;

final class Bic
{
    /** @var string */
    private $bic;

    private function __construct(string $bic)
    {
        $this->bic = $bic;
    }

    public static function fromString(string $bic): self
    {
        $bic = \mb_strtoupper($bic);

        if (!SwiftBic::validate($bic)) {
            throw InvalidBic::withBic($bic);
        }

        return new self($bic);
    }

    public function equals(self $bic): bool
    {
        return $this->bic === $bic->bic;
    }

    public function __toString(): string
    {
        return $this->bic;
    }
}
