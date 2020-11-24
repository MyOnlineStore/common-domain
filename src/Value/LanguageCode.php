<?php

namespace MyOnlineStore\Common\Domain\Value;

use Doctrine\ORM\Mapping as ORM;
use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

/**
 * ISO 639 code (https://en.wikipedia.org/wiki/ISO_639)
 *
 * @ORM\Embeddable
 *
 * @psalm-immutable
 */
final class LanguageCode
{
    /**
     * @ORM\Column(name="language_code", length=3)
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
        if (!\preg_match('/^[a-z]{2,3}$/i', $code)) {
            throw new InvalidArgument(\sprintf('Invalid language code given: %s', $code));
        }

        $this->code = \strtolower($code);
    }

    public function equals(self $comparator): bool
    {
        return $this->code === $comparator->code;
    }

    public function __toString(): string
    {
        return $this->code;
    }
}
