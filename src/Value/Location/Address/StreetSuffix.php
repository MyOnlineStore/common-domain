<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Location\Address;

use MyOnlineStore\Common\Domain\Assertion\Assert;
use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

final class StreetSuffix
{
    /** @var string */
    private $suffix;

    private function __construct(string $suffix)
    {
        $this->suffix = $suffix;
    }

    /**
     * @throws InvalidArgument
     */
    public static function fromString(string $suffix): self
    {
        Assert::notWhitespaceOnly($suffix);

        return new self($suffix);
    }

    public function __toString(): string
    {
        return $this->suffix;
    }
}