<?php

namespace MyOnlineStore\Common\Domain\Value;

/**
 * ISO 639 code (https://en.wikipedia.org/wiki/ISO_639)
 */
final class LanguageCode
{
    /** @var string */
    private $code;

    /**
     * @param mixed $code
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($code)
    {
        if (!\preg_match('/^[a-z]{2,3}$/i', $code)) {
            throw new \InvalidArgumentException(\sprintf('Invalid language code given: %s', $code));
        }

        $this->code = \strtolower($code);
    }

    /**
     * @param LanguageCode $languageCode
     *
     * @return bool
     */
    public function equals(LanguageCode $languageCode)
    {
        return $this->code === (string) $languageCode;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->code;
    }
}
