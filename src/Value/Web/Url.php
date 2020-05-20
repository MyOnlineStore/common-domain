<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Web;

use League\Uri\Http;
use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

final class Url extends Http
{
    /**
     * @throws InvalidArgument
     */
    public static function fromString(string $value): self
    {
        $url = self::createFromString($value);

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
