<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Web;

use LayerShifter\TLDExtract\Extract;
use LayerShifter\TLDExtract\ResultInterface;

/**
 * @psalm-immutable
 */
final class DomainName
{
    /** @var Extract|null */
    private static $validator;

    /** @var ResultInterface */
    private $validatorResult;

    /**
     * @throws \InvalidArgumentException
     */
    public function __construct(string $value)
    {
        if (!isset(self::$validator)) {
            self::$validator = new Extract(
                null,
                null,
                Extract::MODE_ALLOW_ICANN | Extract::MODE_ALLOW_PRIVATE
            );
        }

        /** @psalm-suppress ImpureMethodCall */
        $this->validatorResult = self::$validator->parse($value);

        /** @psalm-suppress ImpureMethodCall */
        if (!$this->validatorResult->isValidDomain()) {
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

    /**
     * @return null|string
     */
    public function getHostName()
    {
        /** @psalm-suppress ImpureMethodCall */
        return $this->validatorResult->getHostname();
    }

    public function getRootDomain(): self
    {
        /** @psalm-suppress ImpureMethodCall */
        return new self((string) $this->validatorResult->getRegistrableDomain());
    }

    public function isRootDomain(): bool
    {
        /** @psalm-suppress ImpureMethodCall */
        return $this->validatorResult->getRegistrableDomain() === $this->validatorResult->getFullHost();
    }

    /**
     * @return null|string
     */
    public function getSubdomain()
    {
        /** @psalm-suppress ImpureMethodCall */
        return $this->validatorResult->getSubdomain();
    }

    /**
     * @return null|string
     */
    public function getTld()
    {
        /** @psalm-suppress ImpureMethodCall */
        return $this->validatorResult->getSuffix();
    }

    public function __toString(): string
    {
        /** @psalm-suppress ImpureMethodCall */
        return $this->validatorResult->getFullHost();
    }
}
