<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Person;

use MyOnlineStore\Common\Domain\Value\Person\Name\FirstName;
use MyOnlineStore\Common\Domain\Value\Person\Name\LastName;

final class Name
{
    /** @var FirstName */
    private $firstName;

    /** @var LastName */
    private $lastName;

    public function __construct(FirstName $firstName, LastName $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
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
