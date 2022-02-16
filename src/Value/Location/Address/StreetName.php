<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Location\Address;

use Doctrine\ORM\Mapping as ORM;
use MyOnlineStore\Common\Domain\Assertion\Assert;
use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

/**
 * @ORM\Embeddable
 *
 * @psalm-immutable
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
     *
     * @psalm-pure
     */
    public static function fromString(string $name): self
    {
        Assert::notWhitespaceOnly($name);

        return new self(\trim($name));
    }

    public function equals(self $operand): bool
    {
        return \mb_strtoupper($this->name) === \mb_strtoupper($operand->name);
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
