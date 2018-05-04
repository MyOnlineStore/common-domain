<?php

namespace MyOnlineStore\Common\Domain\Value;

final class Locale
{
    const FALLBACK_FRONTEND_LOCALE = 'en_GB';

    /**
     * @var RegionCode
     */
    private $regionCode;

    /**
     * @var LanguageCode
     */
    private $languageCode;

    /**
     * @param LanguageCode $languageCode
     * @param RegionCode   $regionCode
     */
    public function __construct(LanguageCode $languageCode, RegionCode $regionCode)
    {
        $this->languageCode = $languageCode;
        $this->regionCode = $regionCode;
    }

    /**
     * @param string $string
     *
     * @return Locale
     *
     * @throws \InvalidArgumentException
     */
    public static function fromString($string)
    {
        if (false === strpos($string, '_')) {
            throw new \InvalidArgumentException(sprintf('Given string "%s" is not a valid string representation of a locale', $string));
        }

        $localeParts = explode('_', $string);

        return new self(new LanguageCode($localeParts[0]), new RegionCode($localeParts[1]));
    }

    /**
     * @param Locale $locale
     *
     * @return bool
     */
    public function equals(Locale $locale)
    {
        return 0 === strcmp($this, $locale);
    }

    /**
     * @return LanguageCode
     */
    public function languageCode()
    {
        return $this->languageCode;
    }

    /**
     * @return RegionCode
     */
    public function regionCode()
    {
        return $this->regionCode;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s_%s', $this->languageCode, $this->regionCode);
    }
}
