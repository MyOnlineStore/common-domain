<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Person\Name;

use Doctrine\ORM\Mapping as ORM;
use MyOnlineStore\Common\Domain\Assertion\Assert;
use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

/**
 * @ORM\Embeddable
 */
final class FirstName
{
    /**
     * @ORM\Column(name="first_name")
     *
     * @var string
     */
    private $firstName;

    private function __construct(string $firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @throws InvalidArgument
     */
    public static function fromString(string $firstName): self
    {
        Assert::notWhitespaceOnly($firstName);

        return new self($firstName);
    }

    public function __toString(): string
    {
        return $this->firstName;
    }
}
