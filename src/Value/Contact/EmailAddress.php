<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Contact;

use MyOnlineStore\Common\Domain\Exception\Mail\InvalidEmailAddress;

/**
 * @final
 * @psalm-immutable
 */
class EmailAddress
{
    private function __construct(
        private string $emailAddress
    ) {
    }

    /**
     * @throws InvalidEmailAddress
     *
     * @psalm-pure
     */
    public static function fromString(string $emailAddress, EmailAddressValidator $validator): self
    {
        $emailAddress = \mb_strtolower($emailAddress);

        if (!$validator($emailAddress)) {
            throw InvalidEmailAddress::withEmailAddress($emailAddress);
        }

        return new self($emailAddress);
    }

    public function equals(self $other): bool
    {
        return $this->emailAddress === $other->emailAddress;
    }

    public function toString(): string
    {
        return $this->emailAddress;
    }
}
