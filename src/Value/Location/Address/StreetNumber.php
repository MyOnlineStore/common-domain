<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Location\Address;

use CuyZ\Valinor\Attribute\StaticMethodConstructor;
use Doctrine\ORM\Mapping as ORM;
use MyOnlineStore\Common\Domain\Assertion\Assert;
use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

/**
 * @ORM\Embeddable
 *
 * @StaticMethodConstructor("fromString")
 *
 * @psalm-immutable
 */
final class StreetNumber
{
    /**
     * @ORM\Column(name="street_number")
     *
     * @var string
     */
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
