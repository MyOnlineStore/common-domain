<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Web;

use MyOnlineStore\Common\Domain\Exception\Web\InvalidHostName;

/**
 * @psalm-immutable
 */
final class UrlHost
{
    /** @var string */
    private $hostname;

    /**
     * @param string $hostname
     *
     * @throws InvalidHostName
     */
    public function __construct($hostname)
    {
        if (!\filter_var('http://' . $hostname, \FILTER_VALIDATE_URL, \FILTER_FLAG_HOST_REQUIRED)) {
            throw new InvalidHostName(\sprintf('"%s" is not a valid UrlHost', $hostname));
        }

        $this->hostname = $hostname;
    }

    public function __toString(): string
    {
        return $this->hostname;
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function getDomainName(): DomainName
    {
        return new DomainName($this->hostname);
    }

    /**
     * @throws InvalidHostName
     *
     * @psalm-pure
     */
    public static function fromDomainName(DomainName $domainName): self
    {
        return new self((string) $domainName);
    }
}
