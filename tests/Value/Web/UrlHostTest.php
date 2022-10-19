<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Web;

use MyOnlineStore\Common\Domain\Exception\Web\InvalidHostName;
use MyOnlineStore\Common\Domain\Value\Web\DomainName;
use MyOnlineStore\Common\Domain\Value\Web\UrlHost;
use PHPUnit\Framework\TestCase;

class UrlHostTest extends TestCase
{
    /** @dataProvider providerValidHostUrls */
    public function testValidUrlHosts(string $hostname): void
    {
        self::assertEquals($hostname, (string) new UrlHost($hostname));
    }

    /** @dataProvider provider */
    public function testInvalidUrlHost(string $hostname): void
    {
        $this->expectException(InvalidHostName::class);
        new UrlHost($hostname);
    }

    public function testValidDomainName(): void
    {
        $urlHost = new UrlHost('pipo.nl');
        self::assertEquals(new DomainName((string) $urlHost), $urlHost->getDomainName());
    }

    /** @dataProvider providerValidHostUrls */
    public function testInValidDomainName(string $hostname): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $urlHost = new UrlHost($hostname);
        $urlHost->getDomainName();
    }

    /** @dataProvider providerValidDomains */
    public function testValidDomainsFromDomainName(string $domainName): void
    {
        self::assertEquals($domainName, (string) UrlHost::fromDomainName(new DomainName($domainName)));
    }

    /** @dataProvider providerValidHostUrls */
    public function testInvalidDomainsFromDomainName(string $domainName): void
    {
        $this->expectException(\InvalidArgumentException::class);

        self::assertEquals($domainName, (string) UrlHost::fromDomainName(new DomainName($domainName)));
    }

    /** @return string[][] */
    public function provider(): array
    {
        return [
            ['!jkfd.com'],
            ['&mfd.com'],
            ['jkfd%jkfdkd.com'],
            ['mail._domainkey.'],
        ];
    }

    /** @return string[][] */
    public function providerValidHostUrls(): array
    {
        return [
            ['localhost'],
            ['martin'],
            ['dezeserverheetgewoonzo'],
        ];
    }

    /** @return string[][] */
    public function providerValidDomains(): array
    {
        return [
            ['localhost.nl'],
            ['martin.com'],
            ['dezeserverheetgewoonzo.co.uk'],
        ];
    }
}
