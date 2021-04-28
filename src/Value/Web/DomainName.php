<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Web;

use MyOnlineStore\Common\Domain\Assertion\Assert;
use Pdp\Cache;
use Pdp\CurlHttpClient;
use Pdp\Domain;
use Pdp\Manager;
use Pdp\Rules;

/**
 * @psalm-immutable
 */
final class DomainName
{
    /** @var string */
    private $domainName;

    /** @var Domain|null */
    private $resolvedDomainName;

    /** @var Rules|null */
    private static $rules;

    /**
     * @throws \InvalidArgumentException
     */
    public function __construct(string $domainName)
    {
        $domainName = \trim($domainName);

        Assert::contains($domainName, '.');

        $this->domainName = $domainName;
    }

    public static function createSubDomain(self $domain, string $subdomain): self
    {
        return new self(\sprintf('%s.%s', $subdomain, $domain));
    }

    public function equals(self $otherDomainName): bool
    {
        return $this->domainName === $otherDomainName->domainName;
    }

    /**
     * @deprecated Should be extracted to external service
     */
    public function getHostName(): ?string
    {
        return \explode('.', (string) $this->getResolvedDomain()->getRegistrableDomain(), 2)[0] ?? null;
    }

    /**
     * @deprecated Should be extracted to external service
     */
    public function getRootDomain(): self
    {
        return new self((string) $this->getResolvedDomain()->getRegistrableDomain());
    }

    /**
     * @deprecated Should be extracted to external service
     */
    public function isRootDomain(): bool
    {
        return $this->getResolvedDomain()->getRegistrableDomain() === $this->getResolvedDomain()->getContent();
    }

    /**
     * @deprecated Should be extracted to external service
     */
    public function getSubdomain(): ?string
    {
        return $this->getResolvedDomain()->getSubDomain();
    }

    /**
     * @deprecated Should be extracted to external service
     */
    public function getTld(): ?string
    {
        /** @psalm-suppress ImpureMethodCall */
        return $this->getResolvedDomain()->getPublicSuffix();
    }

    public function __toString(): string
    {
        return $this->domainName;
    }

    private function getResolvedDomain(): Domain
    {
        if (null === $this->resolvedDomainName) {
            /** @psalm-suppress ImpureStaticProperty */
            if (null === self::$rules) {
                /**
                 * @psalm-suppress ImpureMethodCall
                 * @psalm-suppress ImpureStaticProperty
                 */
                self::$rules = (new Manager(new Cache(), new CurlHttpClient()))->getRules();
            }

            /**
             * @psalm-suppress ImpureMethodCall
             * @psalm-suppress ImpureStaticProperty
             * @psalm-suppress InaccessibleProperty
             */
            $this->resolvedDomainName = self::$rules->resolve($this->domainName);
        }

        return $this->resolvedDomainName;
    }
}
