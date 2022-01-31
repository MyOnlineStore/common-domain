<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Person\Name;

use CuyZ\Valinor\Attribute\StaticMethodConstructor;
use Doctrine\ORM\Mapping as ORM;
use MyOnlineStore\Common\Domain\Assertion\Assert;
use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

/**
 * @ORM\Embeddable
 *
 * @StaticMethodConstructor("fromString")
 *
 * @psalm-immutable
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
