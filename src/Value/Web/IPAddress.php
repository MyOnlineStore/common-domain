<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Web;

/**
 * @final
 * @psalm-immutable
 */
class IPAddress
{
    public const IPV4 = 'IPv4';
    public const IPV6 = 'IPv6';

    private string $ipAddress;

    /**
     * Returns a new IPAddress
     */
    public function __construct(string $ipAddress)
    {
        $filteredValue = \filter_var($ipAddress, \FILTER_VALIDATE_IP);

        if (!$filteredValue) {
            throw new \InvalidArgumentException(\sprintf('opgegeven waarde %s is geen ip address', $ipAddress));
        }

        $this->ipAddress = $filteredValue;
    }

    /**
     * Returns the version (IPv4 or IPv6) of the ip address
     */
    public function getVersion(): string
    {
        $isIPv4 = \filter_var($this->ipAddress, \FILTER_VALIDATE_IP, \FILTER_FLAG_IPV4);

        if (false !== $isIPv4) {
            return self::IPV4;
        }

        return self::IPV6;
    }

    public function isIPv4(): bool
    {
        return self::IPV4 === $this->getVersion();
    }

    public function isIPv6(): bool
    {
        return self::IPV6 === $this->getVersion();
    }

    public function toLong(): int
    {
        if ($this->isIPv6()) {
            throw new \UnexpectedValueException('ipAddress of type v6 cannot be converted to int');
        }

        return \ip2long($this->ipAddress);
    }

    public function toString(): string
    {
        return $this->ipAddress;
    }
}
