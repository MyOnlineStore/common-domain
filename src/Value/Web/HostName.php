<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Web;

/** @psalm-immutable */
final class HostName
{
    /** @var string */
    private $hostName;

    /**
     * @param string $hostName
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($hostName)
    {
        if (!\preg_match('/^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$/', $hostName)) {
            throw new \InvalidArgumentException(\sprintf('Invalid hostname: "%s"', $hostName));
        }

        $this->hostName = $hostName;
    }

    public function __toString(): string
    {
        return $this->hostName;
    }
}
