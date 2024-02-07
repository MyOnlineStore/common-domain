<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Location\Address;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use MyOnlineStore\Common\Domain\Assertion\Assert;
use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

/**
 * @psalm-immutable
 */
#[Embeddable]
final class City
{
    /**
     * @var string
     */
    #[Column(name: 'city')]
    private $city;

    private function __construct(string $city)
    {
        $this->city = $city;
    }

    /**
     * @throws InvalidArgument
     *
     * @psalm-pure
     */
    public static function fromString(string $city): self
    {
        Assert::notWhitespaceOnly($city);

        return new self($city);
    }

    public function equals(self $operand): bool
    {
        return \mb_strtoupper($this->city) === \mb_strtoupper($operand->city);
    }

    public function __toString(): string
    {
        return $this->city;
    }
}
