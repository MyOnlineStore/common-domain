<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Web;

use League\Uri\Http;

final class Url extends Http
{
    /**
     * @param string $value
     */
    public static function fromString($value): self
    {
        $url = self::createFromString($value);

        if (!$url->isValidUri()) {
            throw new \InvalidArgumentException(\sprintf('Invalid URL "%s" provided', $value));
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
