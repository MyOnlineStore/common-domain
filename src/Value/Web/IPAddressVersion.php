<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Web;

/**
 * @psalm-immutable
 */
final class IPAddressVersion
{
    public const IPV4 = 'IPv4';
    public const IPV6 = 'IPv6';
}
