<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Web;

use LayerShifter\TLDExtract\Extract;
use LayerShifter\TLDExtract\ResultInterface;

final class DomainName
{
    /** @var Extract */
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

        $this->validatorResult = self::$validator->parse($value);

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
        return $this->validatorResult->getHostname();
    }

    public function getRootDomain(): self
    {
        return new self((string) $this->validatorResult->getRegistrableDomain());
    }

    public function isRootDomain(): bool
    {
        return $this->validatorResult->getRegistrableDomain() === $this->validatorResult->getFullHost();
    }

    /**
     * @return null|string
     */
    public function getSubdomain()
    {
        return $this->validatorResult->getSubdomain();
    }

    /**
     * @return null|string
     */
    public function getTld()
    {
        return $this->validatorResult->getSuffix();
    }

    public function __toString(): string
    {
        return $this->validatorResult->getFullHost();
    }
}
