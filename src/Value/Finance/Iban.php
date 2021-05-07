<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Finance;

use IsoCodes\Iban as IbanValidator;
use MyOnlineStore\Common\Domain\Exception\Finance\InvalidIban;

/**
 * @final
 * @psalm-immutable
 */
class Iban
{
    public function __construct(
        private string $iban
    ) {
    }

    /**
     * @throws InvalidIban
     */
    public static function fromString(string $iban): self
    {
        $iban = \strtoupper($iban);

        if (!IbanValidator::validate($iban)) {
            throw new InvalidIban(\sprintf('"%s" is not a valid IBAN', $iban));
        }

        return new self($iban);
    }

    public function equals(self $other): bool
    {
        return $this->iban === $other->iban;
    }

    public function toString(): string
    {
        return $this->iban;
    }
}
