<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Web;

use MyOnlineStore\Common\Domain\Value\Web\DomainName;
use PHPUnit\Framework\TestCase;

final class DomainNameTest extends TestCase
{
    public function testToString()
    {
        self::assertEquals('foo.bar', (string) new DomainName('foo.bar'));
    }

    /**
     * @dataProvider getInvalidStringValues
     *
     * @param mixed $value
     */
    public function testInvalidStringValues($value)
    {
        $this->expectException(\InvalidArgumentException::class);

        new DomainName($value);
    }

    /**
     * @dataProvider getValidStringValues
     */
    public function testValidStringValues(string $value)
    {
        self::assertInstanceOf(DomainName::class, new DomainName($value));
    }

    public function testCreateSubDomain()
    {
        self::assertEquals('www.domain.org', (string) DomainName::createSubDomain(new DomainName('domain.org'), 'www'));
        self::assertEquals(
            'www.test.domain.org',
            (string) DomainName::createSubDomain(new DomainName('test.domain.org'), 'www')
        );
    }

    public function testGetSubdomain()
    {
        self::assertEquals('www', (new DomainName('www.google.nl'))->getSubdomain());
        self::assertEquals('www.shop', (new DomainName('www.shop.google.nl'))->getSubdomain());
    }

    public function testGetRootdomain()
    {
        self::assertEquals('google.nl', (new DomainName('www.google.nl'))->getRootDomain());
        self::assertEquals('mijnwebwinkel.co.uk', (new DomainName('www.shop.mijnwebwinkel.co.uk'))->getRootDomain());
    }

    public function testIsRootdomain()
    {
        self::assertFalse((new DomainName('www.google.co.uk'))->isRootDomain());
        self::assertTrue((new DomainName('google.co.uk'))->isRootDomain());
    }

    public function testGetTld()
    {
        self::assertEquals('nl', (new DomainName('www.google.nl'))->getTld());
        self::assertEquals('co.uk', (new DomainName('www.shop.mijnwebwinkel.co.uk'))->getTld());
    }

    public function testGetHostName()
    {
        self::assertEquals('google', (new DomainName('www.google.nl'))->getHostName());
        self::assertEquals('mijnwebwinkel', (new DomainName('www.shop.mijnwebwinkel.co.uk'))->getHostName());
    }

    /**
     * @return string[][]
     */
    public function getInvalidStringValues(): array
    {
        return [
            ['foo'],
        ];
    }

    /**
     * @return string[][]
     */
    public function getValidStringValues(): array
    {
        return [
            ['myonlinestore.com'],
            ['www.google.com'],
        ];
    }
}
