<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Web;

use League\Uri\Contracts\UriInterface;
use League\Uri\Exceptions\SyntaxError;
use League\Uri\Http;
use MyOnlineStore\Common\Domain\Exception\InvalidArgument;
use Psr\Http\Message\UriInterface as Psr7UriInterface;

/**
 * @psalm-immutable
 */
final class Url implements Psr7UriInterface
{
    private function __construct(
        private readonly Http $leagueUri
    ) {
    }

    /**
     * Create a new instance from a string.
     */
    public static function createFromString(mixed $uri = ''): self
    {
        return new self(Http::createFromString($uri));
    }

    /**
     * Create a new instance from a hash of parse_url parts.
     *
     * @param array $components a hash representation of the URI similar
     *                          to PHP parse_url function result
     */
    public static function createFromComponents(array $components): self
    {
        return new self(Http::createFromComponents($components));
    }

    /**
     * Create a new instance from the environment.
     */
    public static function createFromServer(array $server): self
    {
        return new self(Http::createFromServer($server));
    }

    /**
     * Create a new instance from a URI and a Base URI.
     *
     * The returned URI must be absolute.
     *
     * @param mixed $uri      the input URI to create
     * @param mixed $base_uri the base URI used for reference
     */
    public static function createFromBaseUri(mixed $uri, mixed $base_uri = null): self
    {
        return new self(Http::createFromBaseUri($uri, $base_uri));
    }

    /**
     * Create a new instance from a URI object.
     *
     * @param Psr7UriInterface|UriInterface $uri the input URI to create
     */
    public static function createFromUri(Psr7UriInterface|UriInterface $uri): self
    {
        return new self(Http::createFromUri($uri));
    }

    /**
     * @throws InvalidArgument
     *
     * @psalm-pure
     */
    public static function fromString(string $value): self
    {
        /** @psalm-suppress ImpureMethodCall */
        try {
            $url = Http::createFromString($value);
        } catch (SyntaxError $exception) {
            throw new InvalidArgument(
                \sprintf('Invalid URL "%s" provided', $value),
                previous: $exception
            );
        }

        return new self($url);
    }

    public function equals(self $otherUrl): bool
    {
        return $this->leagueUri->getQuery() === $otherUrl->leagueUri->getQuery()
            && $this->leagueUri->getPath() === $otherUrl->leagueUri->getPath()
            && $this->leagueUri->getHost() === $otherUrl->leagueUri->getHost()
            && $this->leagueUri->getPort() === $otherUrl->leagueUri->getPort()
            && $this->leagueUri->getFragment() === $otherUrl->leagueUri->getFragment()
            && $this->leagueUri->getScheme() === $otherUrl->leagueUri->getScheme();
    }

    public function getScheme()
    {
        return $this->leagueUri->getScheme();
    }

    public function getAuthority()
    {
        return $this->leagueUri->getAuthority();
    }

    public function getUserInfo()
    {
        return $this->leagueUri->getUserInfo();
    }

    public function getHost()
    {
        return $this->leagueUri->getHost();
    }

    public function getPort()
    {
        return $this->leagueUri->getPort();
    }

    public function getPath()
    {
        return $this->leagueUri->getPath();
    }

    public function getQuery()
    {
        return $this->leagueUri->getQuery();
    }

    public function getFragment()
    {
        return $this->leagueUri->getFragment();
    }

    public function withScheme($scheme): self
    {
        return new self($this->leagueUri->withScheme($scheme));
    }

    public function withUserInfo($user, $password = null): self
    {
        return new self($this->leagueUri->withUserInfo($user, $password));
    }

    public function withHost($host): self
    {
        return new self($this->leagueUri->withHost($host));
    }

    public function withPort($port): self
    {
        return new self($this->leagueUri->withPort($port));
    }

    public function withPath($path): self
    {
        return new self($this->leagueUri->withPath($path));
    }

    public function withQuery($query): self
    {
        return new self($this->leagueUri->withQuery($query));
    }

    public function withFragment($fragment): self
    {
        return new self($this->leagueUri->withFragment($fragment));
    }

    public function __toString(): string
    {
        return $this->leagueUri->__toString();
    }
}
