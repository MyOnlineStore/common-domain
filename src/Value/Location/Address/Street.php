<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Location\Address;

use Doctrine\ORM\Mapping as ORM;
use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

/**
 * @ORM\Embeddable
 *
 * @psalm-immutable
 */
final class Street
{
    private const SINGLE_LINE_PATTERNS = [
        '/^(?P<street>\d*\D+)\s+(?P<number>\d+)(?P<suffix>.*)$/',
        '/^(?P<number>\d+)(?P<suffix>\w*)\s+(?P<street>.*)$/',
    ];

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

    public function __construct(StreetName $name, StreetNumber $number, StreetSuffix|null $suffix = null)
    {
        $this->name = $name;
        $this->number = $number;
        $this->suffix = $suffix ? (string) $suffix : null;
    }

    /**
     * @throws InvalidArgument
     *
     * @psalm-pure
     */
    public static function fromSingleLine(string $streetAddress): self
    {
        foreach (self::SINGLE_LINE_PATTERNS as $pattern) {
            if (\preg_match($pattern, $streetAddress, $results)) {
                return new self(
                    StreetName::fromString($results['street']),
                    StreetNumber::fromString($results['number']),
                    $results['suffix'] ? StreetSuffix::fromString($results['suffix']) : null,
                );
            }
        }

        throw new InvalidArgument(\sprintf('Unable to parse single line address "%s"', $streetAddress));
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

    public function getSuffix(): StreetSuffix|null
    {
        return $this->suffix ? StreetSuffix::fromString($this->suffix) : null;
    }

    public function __toString(): string
    {
        return \trim(\sprintf('%s %s %s', $this->name, $this->number, $this->suffix ?: ''));
    }
}
