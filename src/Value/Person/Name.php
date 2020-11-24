<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Person;

use Doctrine\ORM\Mapping as ORM;
use MyOnlineStore\Common\Domain\Value\Person\Name\FirstName;
use MyOnlineStore\Common\Domain\Value\Person\Name\LastName;

/**
 * @ORM\Embeddable
 *
 * @psalm-immutable
 */
final class Name
{
    /**
     * @ORM\Embedded(class="MyOnlineStore\Common\Domain\Value\Person\Name\FirstName", columnPrefix=false)
     *
     * @var FirstName
     */
    private $firstName;

    /**
     * @ORM\Embedded(class="MyOnlineStore\Common\Domain\Value\Person\Name\LastName", columnPrefix=false)
     *
     * @var LastName
     */
    private $lastName;

    public function __construct(FirstName $firstName, LastName $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
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
