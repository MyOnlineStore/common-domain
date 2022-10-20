<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value;

use Doctrine\ORM\Mapping as ORM;
use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

/**
 * ISO 3166-1 alpha-2 code (https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2)
 *
 * @ORM\Embeddable
 *
 * @psalm-immutable
 */
final class RegionCode
{
    /**
     * @ORM\Column(name="region_code", type="string", length=2)
     *
     * @var string
     */
    private $code;

    /**
     * @param string $code
     *
     * @throws InvalidArgument
     */
    public function __construct($code)
    {
        if (null === $code) {
            throw new InvalidArgument('RegionCode can not be constructed with an empty ISO code');
        }

        if (!\preg_match('/^[a-z]{2}$/i', $code)) {
            throw new InvalidArgument(\sprintf('Invalid region code given: %s', $code));
        }

        $this->code = \strtoupper($code);
    }

    /** @psalm-pure */
    public static function asNL(): self
    {
        return new self('NL');
    }

    public function equals(self $comparator): bool
    {
        return 0 === \strcmp($this->code, $comparator->code);
    }

    /** @return string returns lowercase value */
    public function lower(): string
    {
        return \strtolower($this->code);
    }

    public function isEuRegion(): bool
    {
        return \in_array(
            $this->code,
            [
                'AT', // Austria
                'BE', // Belgium
                'BG', // Bulgaria
                'CY', // Cyprus
                'CZ', // Czech Republic
                'DE', // Germany
                'DK', // Denmark
                'EE', // Estonia
                'ES', // Spain
                'FI', // Finland
                'FR', // France
                'GR', // Greece
                'HU', // Hungary
                'IE', // Ireland
                'IT', // Italy
                'HR', // Croatia
                'LT', // Lithuania
                'LU', // Luxembourg
                'LV', // Latvia
                'MT', // Malta
                'NL', // Netherlands
                'PL', // Poland
                'PT', // Portugal
                'RO', // Romania
                'SE', // Sweden
                'SI', // Slovenia
                'SK', // Slovakia
            ],
            true,
        );
    }

    public function toString(): string
    {
        return $this->code;
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
