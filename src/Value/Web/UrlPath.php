<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Web;

/**
 * @psalm-immutable
 */
final class UrlPath
{
    /** @var string */
    private $value;

    /**
     * @param string $value
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($value)
    {
        if (!\is_string($value)) {
            throw new \InvalidArgumentException(\sprintf('Provided "%s" is not a string', \gettype($value)));
        }

        $this->value = \ltrim(\parse_url($value, \PHP_URL_PATH), '/');
    }

    public function isEmpty(): bool
    {
        return '' === $this->value;
    }

    public function __toString(): string
    {
        return '/' . $this->value;
    }
}
