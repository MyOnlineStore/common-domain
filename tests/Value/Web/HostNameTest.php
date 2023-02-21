<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Web;

use MyOnlineStore\Common\Domain\Value\Web\HostName;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class HostNameTest extends TestCase
{
    #[DataProvider('providerValidHostNames')]
    public function testValidHostNames(string $hostname): void
    {
        self::assertEquals($hostname, (string) new HostName($hostname));
    }

    #[DataProvider('providerInvalidHostNames')]
    public function testInvalidHostNames(string $hostname): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new HostName($hostname);
    }

    /** @return string[][] */
    public static function providerInvalidHostNames(): array
    {
        return [
            ['!jkfd.com'],
            ['&mfd.com'],
            ['jkfd%jkfdkd.com'],
            ['mail._domainkey.'],
        ];
    }

    /** @return string[][] */
    public static function providerValidHostNames(): array
    {
        return [
            ['localhost'],
            ['martin'],
            ['dezeserverheetgewoonzo'],
        ];
    }
}
