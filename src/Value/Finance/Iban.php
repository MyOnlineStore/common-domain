<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Finance;

use IsoCodes\Iban as IbanValidator;
use MyOnlineStore\Common\Domain\Exception\Finance\InvalidIban;

final class Iban
{
    /**
     * @var string
     */
    private $iban;

    public function __construct(string $iban)
    {
        $iban = \mb_strtoupper($iban);

        if (!IbanValidator::validate($iban)) {
            throw new InvalidIban(\sprintf('"%s" is not a valid IBAN', $iban));
        }

        $this->iban = $iban;
    }

    public function equals(self $other): bool
    {
        return \get_class($this) === \get_class($other) && $this->iban === $other->iban;
    }

    public function __toString(): string
    {
        return $this->iban;
    }
}
