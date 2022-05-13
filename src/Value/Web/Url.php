<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Web;

use League\Uri\Http;
use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

/**
 * @psalm-immutable
 */
final class Url extends Http
{
    /**
     * @throws InvalidArgument
     *
     * @psalm-pure
     */
    public static function fromString(string $value): self
    {
        /** @psalm-suppress ImpureMethodCall */
        $url = self::createFromString($value);

        /** @psalm-suppress ImpureMethodCall */
        if (!$url->isValidUri()) {
            throw new InvalidArgument(\sprintf('Invalid URL "%s" provided', $value));
        }

        return $url;
    }

    public function equals(self $otherUrl): bool
    {
        return $this->query === $otherUrl->query
            && $this->path === $otherUrl->path
            && $this->host === $otherUrl->host
            && $this->port === $otherUrl->port
            && $this->fragment === $otherUrl->fragment
            && $this->scheme === $otherUrl->scheme;
    }
}
