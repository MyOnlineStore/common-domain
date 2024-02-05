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
final class FirstName
{
    /**
     * @var string
     */
    #[Column(name: 'first_name')]
    private $firstName;

    private function __construct(string $firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @throws InvalidArgument
     *
     * @psalm-pure
     */
    public static function fromString(string $firstName): self
    {
        Assert::notWhitespaceOnly($firstName);

        return new self($firstName);
    }

    public function equals(self $operand): bool
    {
        return \mb_strtoupper($this->firstName) === \mb_strtoupper($operand->firstName);
    }

    public function __toString(): string
    {
        return $this->firstName;
    }
}
