<?php

namespace MyOnlineStore\Common\Domain\Value;

use Doctrine\ORM\Mapping as ORM;
use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

/**
 * @ORM\Embeddable
 *
 * @psalm-immutable
 */
final class Locale
{
    public const FALLBACK_FRONTEND_LOCALE = 'en_GB';

    /**
     * @ORM\Embedded(class="MyOnlineStore\Common\Domain\Value\RegionCode", columnPrefix=false)
     *
     * @var RegionCode
     */
    private $regionCode;

    /**
     * @ORM\Embedded(class="MyOnlineStore\Common\Domain\Value\LanguageCode", columnPrefix=false)
     *
     * @var LanguageCode
     */
    private $languageCode;

    public function __construct(LanguageCode $languageCode, RegionCode $regionCode)
    {
        $this->languageCode = $languageCode;
        $this->regionCode = $regionCode;
    }

    /**
     * @param string $string
     *
     * @throws InvalidArgument
     *
     * @psalm-pure
     */
    public static function fromString($string): self
    {
        if (!\str_contains($string, '_')) {
            throw new InvalidArgument(
                \sprintf('Given string "%s" is not a valid string representation of a locale', $string),
            );
        }

        $localeParts = \explode('_', $string);

        return new self(new LanguageCode($localeParts[0]), new RegionCode($localeParts[1]));
    }

    public function equals(self $locale): bool
    {
        return $this->regionCode->equals($locale->regionCode) &&
            $this->languageCode->equals($locale->languageCode);
    }

    public function languageCode(): LanguageCode
    {
        return $this->languageCode;
    }

    public function regionCode(): RegionCode
    {
        return $this->regionCode;
    }

    public function toString(): string
    {
        return \sprintf('%s_%s', $this->languageCode, $this->regionCode);
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
