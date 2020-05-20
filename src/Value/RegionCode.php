<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value;

use Doctrine\ORM\Mapping as ORM;
use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

/**
 * ISO 3166-1 alpha-2 code (https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2)
 *
 * @ORM\Embeddable
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

    public static function asNL(): self
    {
        return new self('NL');
    }

    public function equals(self $comparator): bool
    {
        return 0 === \strcmp($this->code, $comparator->code);
    }

    /**
     * @return string returns lowercase value
     */
    public function lower(): string
    {
        return \strtolower($this->code);
    }

    public function isEuRegion(): bool
    {
        $euRegions = [
            'AT' => 'AT', // Austria
            'BE' => 'BE', // Belgium
            'BG' => 'BG', // Bulgaria
            'CY' => 'CY', // Cyprus
            'CZ' => 'CZ', // Czech Republic
            'DE' => 'DE', // Germany
            'DK' => 'DK', // Denmark
            'EE' => 'EE', // Estonia
            'ES' => 'ES', // Spain
            'FI' => 'FI', // Finland
            'FR' => 'FR', // France
            'GB' => 'GB', // United Kingdom
            'GR' => 'GR', // Greece
            'HU' => 'HU', // Hungary
            'IE' => 'IE', // Ireland
            'IT' => 'IT', // Italy
            'HR' => 'HR', // Croatia
            'LT' => 'LT', // Lithuania
            'LU' => 'LU', // Luxembourg
            'LV' => 'LV', // Latvia
            'MT' => 'MT', // Malta
            'NL' => 'NL', // Netherlands
            'PL' => 'PL', // Poland
            'PT' => 'PT', // Portugal
            'RO' => 'RO', // Romania
            'SE' => 'SE', // Sweden
            'SI' => 'SI', // Slovenia
            'SK' => 'SK', // Slovakia
        ];

        return isset($euRegions[$this->code]);
    }

    public function __toString(): string
    {
        return $this->code;
    }
}
