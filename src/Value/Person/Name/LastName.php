<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Person\Name;

use MyOnlineStore\Common\Domain\Assertion\Assert;
use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

final class LastName
{
    /** @var string */
    private $lastName;

    private function __construct(string $lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @throws InvalidArgument
     */
    public static function fromString(string $lastName): self
    {
        Assert::notWhitespaceOnly($lastName);

        return new self($lastName);
    }

    public function __toString(): string
    {
        return $this->lastName;
    }
}
