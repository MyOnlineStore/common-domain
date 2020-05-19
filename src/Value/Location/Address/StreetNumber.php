<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Location\Address;

use MyOnlineStore\Common\Domain\Assertion\Assert;
use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

final class StreetNumber
{
    /** @var string */
    private $number;

    private function __construct(string $number)
    {
        $this->number = $number;
    }

    /**
     * @throws InvalidArgument
     */
    public static function fromString(string $number): self
    {
        Assert::notWhitespaceOnly($number);

        return new self($number);
    }

    public function __toString(): string
    {
        return $this->number;
    }
}
