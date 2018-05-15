<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value;

use Doctrine\ORM\Mapping as ORM;

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
     * @throws \InvalidArgumentException
     */
    public function __construct($code)
    {
        if (null === $code) {
            throw new \InvalidArgumentException('RegionCode can not be constructed with an empty ISO code');
        }

        if (!preg_match('/^[a-z]{2}$/i', $code)) {
            throw new \InvalidArgumentException(sprintf('Invalid region code given: %s', $code));
        }

        $this->code = strtoupper($code);
    }

    /**
     * @param RegionCode $otherRegion
     *
     * @return bool
     */
    public function equals(RegionCode $otherRegion): bool
    {
        return 0 === strcmp($this->code, (string) $otherRegion);
    }

    /**
     * @return string returns lowercased value
     */
    public function lower(): string
    {
        return strtolower($this->code);
    }

    /**
     * @return bool
     */
    public function isEuRegion(): bool
    {
        $euRegions = [
            'BE' => 'BE',
            'BG' => 'BG',
            'CY' => 'CY',
            'DE' => 'DE',
            'DK' => 'DK',
            'EE' => 'EE',
            'FI' => 'FI',
            'FR' => 'FR',
            'GR' => 'GR',
            'HU' => 'HU',
            'IE' => 'IE',
            'IT' => 'IT',
            'HR' => 'HR',
            'LV' => 'LV',
            'LT' => 'LT',
            'MT' => 'MT',
            'NL' => 'NL',
            'AT' => 'AT',
            'PL' => 'PL',
            'PT' => 'PT',
            'RO' => 'RO',
            'SI' => 'SI',
            'SK' => 'SK',
            'ES' => 'ES',
            'CZ' => 'CZ',
            'GB' => 'GB',
            'SE' => 'SE',
        ];

        return isset($euRegions[$this->code]);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->code;
    }
}
