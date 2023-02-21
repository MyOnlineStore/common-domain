<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Web;

use MyOnlineStore\Common\Domain\Value\Web\DomainName;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class DomainNameTest extends TestCase
{
    public function testToString(): void
    {
        self::assertEquals('foo.bar', (string) new DomainName('foo.bar'));
    }

    #[DataProvider('getInvalidStringValues')]
    public function testInvalidStringValues(mixed $value): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new DomainName($value);
    }

    #[DataProvider('getValidStringValues')]
    public function testValidStringValues(string $value): void
    {
        self::assertInstanceOf(DomainName::class, new DomainName($value));
    }

    public function testCreateSubDomain(): void
    {
        self::assertEquals('www.domain.org', (string) DomainName::createSubDomain(new DomainName('domain.org'), 'www'));
        self::assertEquals(
            'www.test.domain.org',
            (string) DomainName::createSubDomain(new DomainName('test.domain.org'), 'www'),
        );
    }

    public function testGetSubdomain(): void
    {
        self::assertEquals('www', (new DomainName('www.google.nl'))->getSubdomain());
        self::assertEquals('www.shop', (new DomainName('www.shop.google.nl'))->getSubdomain());
    }

    public function testGetRootdomain(): void
    {
        self::assertEquals('google.nl', (new DomainName('www.google.nl'))->getRootDomain());
        self::assertEquals('mijnwebwinkel.co.uk', (new DomainName('www.shop.mijnwebwinkel.co.uk'))->getRootDomain());
        self::assertEquals('mijnwebwinkel.co.uk', (new DomainName(' www.shop.mijnwebwinkel.co.uk'))->getRootDomain());
    }

    public function testIsRootdomain(): void
    {
        self::assertFalse((new DomainName('www.google.co.uk'))->isRootDomain());
        self::assertTrue((new DomainName('google.co.uk'))->isRootDomain());
    }

    public function testGetTld(): void
    {
        self::assertEquals('nl', (new DomainName('www.google.nl'))->getTld());
        self::assertEquals('co.uk', (new DomainName('www.shop.mijnwebwinkel.co.uk'))->getTld());
    }

    public function testGetHostName(): void
    {
        self::assertEquals('google', (new DomainName('www.google.nl'))->getHostName());
        self::assertEquals('mijnwebwinkel', (new DomainName('www.shop.mijnwebwinkel.co.uk'))->getHostName());
    }

    /** @return string[][] */
    public static function getInvalidStringValues(): array
    {
        return [
            ['foo'],
        ];
    }

    /** @return string[][] */
    public static function getValidStringValues(): array
    {
        return [
            ['myonlinestore.com'],
            ['www.google.com'],
        ];
    }
}
