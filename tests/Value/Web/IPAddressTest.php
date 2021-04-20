<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Web;

use MyOnlineStore\Common\Domain\Value\Web\IPAddress;
use PHPUnit\Framework\TestCase;

final class IPAddressTest extends TestCase
{
    public const IPV4_ADDRESS = '213.125.219.90';
    public const IPV6_ADDRESS = '2002:D57D:DB5A:0:0:0:0:0';

    public function testCorrectCreationIpv4(): void
    {
        $ipAddress = new IPAddress(self::IPV4_ADDRESS);

        self::assertEquals(IPAddress::IPV4, $ipAddress->getVersion());
        self::assertEquals(self::IPV4_ADDRESS, $ipAddress->toString());
    }

    public function testCorrectCreationIpv6(): void
    {
        $ipAddress = new IPAddress(self::IPV6_ADDRESS);

        self::assertEquals(IPAddress::IPV6, $ipAddress->getVersion());
        self::assertEquals(self::IPV6_ADDRESS, $ipAddress->toString());
    }

    public function testIsIPv4(): void
    {
        $ipAddress1 = new IPAddress(self::IPV6_ADDRESS);
        $ipAddress2 = new IPAddress(self::IPV4_ADDRESS);

        self::assertTrue($ipAddress2->isIPv4());
        self::assertFalse($ipAddress1->isIPv4());
    }

    public function testIsIPv6(): void
    {
        $ipAddress1 = new IPAddress(self::IPV6_ADDRESS);
        $ipAddress2 = new IPAddress(self::IPV4_ADDRESS);

        self::assertTrue($ipAddress1->isIPv6());
        self::assertFalse($ipAddress2->isIPv6());
    }

    public function testAsLong(): void
    {
        $address = new IPAddress(self::IPV4_ADDRESS);

        self::assertSame(3581795162, $address->toLong());
    }

    public function testAsLongIpv6ShouldThrowError(): void
    {
        $this->expectException(\UnexpectedValueException::class);

        $ipAddress = new IPAddress(self::IPV6_ADDRESS);

        $ipAddress->toLong();
    }

    public function testFaultCreation(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new IPAddress('blaat');
    }
}
