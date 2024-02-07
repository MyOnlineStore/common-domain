<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Location\Address;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use MyOnlineStore\Common\Domain\Assertion\Assert;
use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

/** @psalm-immutable */
#[Embeddable]
final class StreetName
{
    /** @var string */
    #[Column(name: 'street_name')]
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
