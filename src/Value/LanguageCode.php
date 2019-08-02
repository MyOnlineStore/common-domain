<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value;

/**
 * ISO 639 code (https://en.wikipedia.org/wiki/ISO_639)
 */
final class LanguageCode
{
    /**
     * @var string
     */
    private $code;

    /**
     * @throws \InvalidArgumentException
     */
    public function __construct(string $code)
    {
        if (!\preg_match('/^[a-z]{2,3}$/i', $code)) {
            throw new \InvalidArgumentException(\sprintf('Invalid language code given: %s', $code));
        }

        $this->code = \strtolower($code);
    }

    public function equals(LanguageCode $languageCode): bool
    {
        return $this->code === (string) $languageCode;
    }

    public function __toString(): string
    {
        return $this->code;
    }
}
