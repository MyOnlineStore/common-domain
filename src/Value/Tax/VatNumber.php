<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Tax;

use MyOnlineStore\Common\Domain\Exception\Tax\InvalidVatNumber;

/**
 * @final
 * @psalm-immutable
 */
class VatNumber
{
    private function __construct(
        private string $vatNumber
    ) {
    }

    /**
     * @throws InvalidVatNumber
     *
     * @psalm-pure
     */
    public static function fromString(string $vatNumber, VatNumberValidator $validator): self
    {
        $vatNumber = \strtoupper($vatNumber);

        if (!$validator($vatNumber)) {
            throw InvalidVatNumber::withVatNumber($vatNumber);
        }

        return new self($vatNumber);
    }

    public function equals(self $other): bool
    {
        return $this->vatNumber === $other->vatNumber;
    }

    public function toString(): string
    {
        return $this->vatNumber;
    }
}
