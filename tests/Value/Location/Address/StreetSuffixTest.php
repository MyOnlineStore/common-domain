<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Location\Address;

use MyOnlineStore\Common\Domain\Exception\InvalidArgument;
use MyOnlineStore\Common\Domain\Value\Location\Address\StreetSuffix;
use PHPUnit\Framework\TestCase;

final class StreetSuffixTest extends TestCase
{
    public function testNotEmpty(): void
    {
        self::assertSame('foo', (string) StreetSuffix::fromString('foo'));
        self::assertSame('foo', (string) StreetSuffix::fromString(' foo '));
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
        StreetSuffix::fromString($empty);
    }

    public function testEquals(): void
    {
        $suffix = StreetSuffix::fromString('foo');

        self::assertTrue($suffix->equals(StreetSuffix::fromString('foo')));
        self::assertTrue($suffix->equals(StreetSuffix::fromString('FoO')));
        self::assertFalse($suffix->equals(StreetSuffix::fromString('bar')));
    }
}
