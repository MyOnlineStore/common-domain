<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Location\Address;

use MyOnlineStore\Common\Domain\Assertion\Assert;
use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

final class City
{
    /** @var string */
    private $city;

    private function __construct(string $city)
    {
        $this->city = $city;
    }

    /**
     * @throws InvalidArgument
     */
    public static function fromString(string $city): self
    {
        Assert::notWhitespaceOnly($city);

        return new self($city);
    }

    public function __toString(): string
    {
        return $this->city;
    }
}
