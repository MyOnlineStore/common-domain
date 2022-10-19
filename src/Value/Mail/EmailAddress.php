<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Mail;

use Doctrine\ORM\Mapping as ORM;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;
use MyOnlineStore\Common\Domain\Exception\Mail\InvalidEmailAddress;

/**
 * @ORM\Embeddable
 *
 * @psalm-immutable
 */
final class EmailAddress
{
    /**
     * @ORM\Column(name="email_address")
     *
     * @var string
     */
    private $emailAddress;

    /** @throws InvalidEmailAddress */
    public function __construct(string $emailAddress)
    {
        $validator = new EmailValidator();

        /** @psalm-suppress ImpureMethodCall */
        if (!$validator->isValid($emailAddress, new RFCValidation())) {
            throw new InvalidEmailAddress(\sprintf('"%s" is not a valid email address', $emailAddress));
        }

        $this->emailAddress = \mb_strtolower($emailAddress);
    }

    public function equals(self $comparator): bool
    {
        return $this->emailAddress === $comparator->emailAddress;
    }

    public function toString(): string
    {
        return $this->emailAddress;
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
