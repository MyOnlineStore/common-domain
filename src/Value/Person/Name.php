<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Person;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use MyOnlineStore\Common\Domain\Value\Person\Name\FirstName;
use MyOnlineStore\Common\Domain\Value\Person\Name\LastName;

/**
 * @psalm-immutable
 */
#[Embeddable]
final class Name
{
    /**
     * @var FirstName
     */
    #[Embedded(class: 'MyOnlineStore\Common\Domain\Value\Person\Name\FirstName', columnPrefix: false)]
    private $firstName;

    /**
     * @var LastName
     */
    #[Embedded(class: 'MyOnlineStore\Common\Domain\Value\Person\Name\LastName', columnPrefix: false)]
    private $lastName;

    public function __construct(FirstName $first, LastName $last)
    {
        $this->firstName = $first;
        $this->lastName = $last;
    }

    public function equals(self $operand): bool
    {
        return $this->firstName->equals($operand->firstName) &&
            $this->lastName->equals($operand->lastName);
    }

    public function getFirstName(): FirstName
    {
        return $this->firstName;
    }

    public function getLastName(): LastName
    {
        return $this->lastName;
    }

    public function __toString(): string
    {
        return \sprintf('%s %s', $this->firstName, $this->lastName);
    }
}
