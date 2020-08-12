<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Location\Address;

use Doctrine\ORM\Mapping as ORM;
use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

/**
 * @ORM\Embeddable
 */
final class Street
{
    /**
     * @ORM\Embedded(class="MyOnlineStore\Common\Domain\Value\Location\Address\StreetName", columnPrefix=false)
     *
     * @var StreetName
     */
    private $name;

    /**
     * @ORM\Embedded(class="MyOnlineStore\Common\Domain\Value\Location\Address\StreetNumber", columnPrefix=false)
     *
     * @var StreetNumber
     */
    private $number;

    /**
     * @ORM\Column(name="street_suffix", nullable=true)
     *
     * @var string|null
     */
    private $suffix;

    public function __construct(StreetName $name, StreetNumber $number, ?StreetSuffix $suffix = null)
    {
        $this->name = $name;
        $this->number = $number;
        $this->suffix = $suffix ? (string) $suffix : null;
    }

    /**
     * @throws InvalidArgument
     */
    public static function fromSingleLine(string $streetAddress): self
    {
        if (\preg_match('/^(\D*[^\d\s]) *([\d]+)(.*)$/', $streetAddress, $results)) {
            return new self(
                StreetName::fromString($results[1]),
                StreetNumber::fromString($results[2]),
                !empty(\trim($results[3])) ? StreetSuffix::fromString($results[3]) : null
            );
        }

        throw new InvalidArgument('Unable to parse single line address');
    }

    public function equals(self $operand): bool
    {
        return $this->name->equals($operand->name) &&
            $this->number->equals($operand->number) &&
            $this->suffix === $operand->suffix;
    }

    public function getName(): StreetName
    {
        return $this->name;
    }

    public function getNumber(): StreetNumber
    {
        return $this->number;
    }

    public function getSuffix(): ?StreetSuffix
    {
        return $this->suffix ? StreetSuffix::fromString($this->suffix) : null;
    }

    public function __toString(): string
    {
        return \trim(\sprintf('%s %s %s', $this->name, $this->number, $this->suffix ?: ''));
    }
}
