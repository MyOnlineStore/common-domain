<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value;

use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

/**
 * @final
 * @psalm-immutable
 */
class Locale
{
    public function __construct(
        public LanguageCode $languageCode,
        public RegionCode $regionCode
    ) {
    }

    /**
     * @throws InvalidArgument
     *
     * @psalm-pure
     */
    public static function fromString(string $string): self
    {
        $localeParts = \explode('_', $string);

        if (2 !== \count($localeParts)) {
            throw new InvalidArgument(
                \sprintf('Given string "%s" is not a valid string representation of a locale', $string)
            );
        }

        return new self(LanguageCode::fromString($localeParts[0]), RegionCode::fromString($localeParts[1]));
    }

    public function equals(self $other): bool
    {
        return $this->regionCode->equals($other->regionCode)
            && $this->languageCode->equals($other->languageCode);
    }

    public function toString(): string
    {
        return \sprintf('%s_%s', $this->languageCode->toString(), $this->regionCode->toString());
    }
}
