<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Location\Address;

use MyOnlineStore\Common\Domain\Assertion\Assert;
use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

/**
 * @psalm-immutable
 */
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
     *
     * @psalm-pure
     */
    public static function fromString(string $suffix): self
    {
        Assert::notWhitespaceOnly($suffix);

        return new self(\trim($suffix));
    }

    public function equals(self $operand): bool
    {
        return \mb_strtoupper($this->suffix) === \mb_strtoupper($operand->suffix);
    }

    public function __toString(): string
    {
        return $this->suffix;
    }
}
