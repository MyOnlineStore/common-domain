<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value;

use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

/**
 * ISO 3166-1 alpha-2 code (https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2)
 *
 * @psalm-immutable
 */
final class RegionCode
{
    private function __construct(
        private string $code
    ) {
    }

    /**
     * @throws InvalidArgument
     *
     * @psalm-pure
     */
    public static function fromString(string $code): self
    {
        if (!\preg_match('/^[a-z]{2}$/i', $code)) {
            throw new InvalidArgument(\sprintf('Invalid region code given: %s', $code));
        }

        return new self(\strtoupper($code));
    }

    public function equals(self $other): bool
    {
        return $this->code === $other->code;
    }

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
            true
        );
    }

    public function toString(): string
    {
        return $this->code;
    }
}
