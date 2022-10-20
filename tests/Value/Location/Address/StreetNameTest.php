<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Location\Address;

use MyOnlineStore\Common\Domain\Exception\InvalidArgument;
use MyOnlineStore\Common\Domain\Value\Location\Address\StreetName;
use PHPUnit\Framework\TestCase;

final class StreetNameTest extends TestCase
{
    public function testNotEmpty(): void
    {
        self::assertSame('foo', (string) StreetName::fromString('foo'));
        self::assertSame('foo', (string) StreetName::fromString(' foo '));
    }

    public function emptyDataProvider(): \Generator
    {
        yield [''];
        yield [' '];
        yield ['  '];
        yield ["\t"];
        yield ["\t "];
    }

    /** @dataProvider emptyDataProvider */
    public function testEmpty(string $empty): void
    {
        $this->expectException(InvalidArgument::class);
        StreetName::fromString($empty);
    }

    public function testEquals(): void
    {
        $streetName = StreetName::fromString('foo');

        self::assertTrue($streetName->equals(StreetName::fromString('foo')));
        self::assertTrue($streetName->equals(StreetName::fromString('FoO')));
        self::assertFalse($streetName->equals(StreetName::fromString('bar')));
    }
}
