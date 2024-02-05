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
final class StreetNumber
{
    /**
     * @var string
     */
    #[Column(name: 'street_number')]
    private $number;

    private function __construct(string $number)
    {
        $this->number = $number;
    }

    /**
     * @throws InvalidArgument
     *
     * @psalm-pure
     */
    public static function fromString(string $number): self
    {
        Assert::notWhitespaceOnly($number);

        return new self(\trim($number));
    }

    public function equals(self $operand): bool
    {
        return \mb_strtoupper($this->number) === \mb_strtoupper($operand->number);
    }

    public function __toString(): string
    {
        return $this->number;
    }
}
