<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Web;

use Pdp\Cache;
use Pdp\CurlHttpClient;
use Pdp\Domain;
use Pdp\Manager;

/**
 * @psalm-immutable
 */
final class DomainName
{
    /** @var Domain */
    private $domain;

    /**
     * @throws \InvalidArgumentException
     */
    public function __construct(string $value)
    {
        $manager = new Manager(new Cache(), new CurlHttpClient());
        /** @psalm-suppress ImpureMethodCall */
        $this->domain = $manager->getRules()->resolve($value);

        if (null === $this->domain->getRegistrableDomain()) {
            throw new \InvalidArgumentException(\sprintf('Invalid domain name: "%s"', $value));
        }
    }

    public static function createSubDomain(self $domain, string $subdomain): self
    {
        return new self(\sprintf('%s.%s', $subdomain, $domain));
    }

    public function equals(self $otherDomainName): bool
    {
        return (string) $this === (string) $otherDomainName;
    }

    public function getHostName(): ?string
    {
        return \explode('.', (string) $this->domain->getRegistrableDomain(), 2)[0] ?? null;
    }

    public function getRootDomain(): self
    {
        return new self((string) $this->domain->getRegistrableDomain());
    }

    public function isRootDomain(): bool
    {
        return $this->domain->getRegistrableDomain() === $this->domain->getContent();
    }

    public function getSubdomain(): ?string
    {
        return $this->domain->getSubDomain();
    }

    public function getTld(): ?string
    {
        /** @psalm-suppress ImpureMethodCall */
        return $this->domain->getPublicSuffix();
    }

    public function __toString(): string
    {
        return (string) $this->domain->getContent();
    }
}
