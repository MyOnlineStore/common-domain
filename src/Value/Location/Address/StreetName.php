<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Location\Address;

use MyOnlineStore\Common\Domain\Assertion\Assert;
use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

final class StreetName
{
    /** @var string */
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

    public function __toString(): string
    {
        return $this->name;
    }
}
