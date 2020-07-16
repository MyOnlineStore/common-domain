<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Location\Address;

use Doctrine\ORM\Mapping as ORM;
use MyOnlineStore\Common\Domain\Assertion\Assert;
use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

/**
 * @ORM\Embeddable
 */
final class StreetName
{
    /**
     * @ORM\Column(name="street_name")
     *
     * @var string
     */
    private $name;

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @throws InvalidArgument
     */
    public static function fromString(string $name): self
    {
        Assert::notWhitespaceOnly($name);

        return new self($name);
    }

    public function equals(self $operand): bool
    {
        return $this->name === $operand->name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
