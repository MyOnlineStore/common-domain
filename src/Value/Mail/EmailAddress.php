<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Mail;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;
use MyOnlineStore\Common\Domain\Exception\Mail\InvalidEmailAddress;

final class EmailAddress
{
    /**
     * @var string
     */
    private $emailAddress;

    public function __construct(string $emailAddress)
    {
        $validator = new EmailValidator();

        if (!$validator->isValid($emailAddress, new RFCValidation())) {
            throw new InvalidEmailAddress(\sprintf('"%s" is not a valid email address', $emailAddress));
        }

        $this->emailAddress = $emailAddress;
    }

    public function equals(self $other): bool
    {
        return \get_class($this) === \get_class($other) && $this->emailAddress === $other->emailAddress;
    }

    public function __toString(): string
    {
        return $this->emailAddress;
    }
}
