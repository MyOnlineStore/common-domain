<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Location\Address;

use Doctrine\ORM\Mapping as ORM;

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
