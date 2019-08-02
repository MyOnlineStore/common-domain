<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value;

final class Locale
{
    /**
     * @var RegionCode
     */
    private $regionCode;

    /**
     * @var LanguageCode
     */
    private $languageCode;

    public function __construct(LanguageCode $languageCode, RegionCode $regionCode)
    {
        $this->languageCode = $languageCode;
        $this->regionCode = $regionCode;
    }

    /**
     * @throws \InvalidArgumentException
     */
    public static function fromString(string $string): Locale
    {
        if (false === \strpos($string, '_')) {
            throw new \InvalidArgumentException(
                \sprintf('Given string "%s" is not a valid string representation of a locale', $string)
            );
        }

        $localeParts = \explode('_', $string);

        return new self(new LanguageCode($localeParts[0]), new RegionCode($localeParts[1]));
    }

    public function equals(Locale $locale): bool
    {
        return 0 === \strcmp((string) $this, (string) $locale);
    }

    public function languageCode(): LanguageCode
    {
        return $this->languageCode;
    }

    public function regionCode(): RegionCode
    {
        return $this->regionCode;
    }

    public function __toString(): string
    {
        return \sprintf('%s_%s', $this->languageCode, $this->regionCode);
    }
}
