<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Location\Address;

use MyOnlineStore\Common\Domain\Exception\InvalidArgument;
use MyOnlineStore\Common\Domain\Value\Location\Address\City;
use PHPUnit\Framework\TestCase;

final class CityTest extends TestCase
{
    public function testNotEmpty(): void
    {
        self::assertSame('foo', (string) City::fromString('foo'));
    }

    public function emptyDataProvider(): \Generator
    {
        yield [''];
        yield [' '];
        yield ['  '];
        yield ["\t"];
        yield ["\t "];
    }

    /**
     * @dataProvider emptyDataProvider
     */
    public function testEmpty(string $empty): void
    {
        $this->expectException(InvalidArgument::class);
        City::fromString($empty);
    }

    public function testEquals(): void
    {
        $streetName = City::fromString('foo');

        self::assertTrue($streetName->equals(City::fromString('foo')));
        self::assertTrue($streetName->equals(City::fromString('FoO')));
        self::assertFalse($streetName->equals(City::fromString('bar')));
    }
}
