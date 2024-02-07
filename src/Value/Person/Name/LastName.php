<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Person\Name;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use MyOnlineStore\Common\Domain\Assertion\Assert;
use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

/**
 * @psalm-immutable
 */
#[Embeddable]
final class LastName
{
    /**
     * @var string
     */
    #[Column(name: 'last_name')]
    private $lastName;

    private function __construct(string $lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @throws InvalidArgument
     *
     * @psalm-pure
     */
    public static function fromString(string $lastName): self
    {
        Assert::notWhitespaceOnly($lastName);

        return new self($lastName);
    }

    public function equals(self $operand): bool
    {
        return \mb_strtoupper($this->lastName) === \mb_strtoupper($operand->lastName);
    }

    public function __toString(): string
    {
        return $this->lastName;
    }
}
