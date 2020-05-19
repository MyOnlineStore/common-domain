<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Location\Address;

final class Street
{
    /** @var StreetName */
    private $name;

    /** @var StreetNumber */
    private $number;

    /** @var StreetSuffix|null */
    private $suffix;

    public function __construct(StreetName $name, StreetNumber $number, ?StreetSuffix $suffix = null)
    {
        $this->name = $name;
        $this->number = $number;
        $this->suffix = $suffix;
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
        return $this->suffix;
    }
}
