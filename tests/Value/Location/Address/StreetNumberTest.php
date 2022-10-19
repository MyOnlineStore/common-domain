<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Location\Address;

use MyOnlineStore\Common\Domain\Exception\InvalidArgument;
use MyOnlineStore\Common\Domain\Value\Location\Address\StreetNumber;
use PHPUnit\Framework\TestCase;

final class StreetNumberTest extends TestCase
{
    public function testNotEmpty(): void
    {
        self::assertSame('foo', (string) StreetNumber::fromString('foo'));
        self::assertSame('foo', (string) StreetNumber::fromString(' foo '));
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
        StreetNumber::fromString($empty);
    }

    public function testEquals(): void
    {
        $streetNumber = StreetNumber::fromString('foo');

        self::assertTrue($streetNumber->equals(StreetNumber::fromString('foo')));
        self::assertTrue($streetNumber->equals(StreetNumber::fromString('FoO')));
        self::assertFalse($streetNumber->equals(StreetNumber::fromString('bar')));
    }
}
