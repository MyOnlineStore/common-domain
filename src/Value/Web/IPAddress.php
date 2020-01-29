<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Web;

final class IPAddress
{
    /**
     * @var string
     */
    private $value;

    /**
     * Returns a new IPAddress
     *
     * @param string $value
     */
    public function __construct($value)
    {
        $filteredValue = \filter_var($value, \FILTER_VALIDATE_IP);

        if (!$filteredValue) {
            throw new \InvalidArgumentException(\sprintf('opgegeven waarde %s is geen ip address', $value));
        }

        $this->value = $filteredValue;
    }

    /**
     * Returns the version (IPv4 or IPv6) of the ip address
     */
    public function getVersion(): string
    {
        $isIPv4 = \filter_var($this->value, \FILTER_VALIDATE_IP, \FILTER_FLAG_IPV4);

        if (false !== $isIPv4) {
            return IPAddressVersion::IPV4;
        }

        return IPAddressVersion::IPV6;
    }

    public function isIPv4(): bool
    {
        return IPAddressVersion::IPV4 === $this->getVersion();
    }

    public function isIPv6(): bool
    {
        return IPAddressVersion::IPV6 === $this->getVersion();
    }

    public function asLong(): int
    {
        if ($this->isIPv6()) {
            throw new \UnexpectedValueException('ipAddress of type v6 cannot be converted to int');
        }

        return \ip2long($this->value);
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
