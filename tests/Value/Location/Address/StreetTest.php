<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Location\Address;

use MyOnlineStore\Common\Domain\Exception\InvalidArgument;
use MyOnlineStore\Common\Domain\Value\Location\Address\Street;
use MyOnlineStore\Common\Domain\Value\Location\Address\StreetName;
use MyOnlineStore\Common\Domain\Value\Location\Address\StreetNumber;
use MyOnlineStore\Common\Domain\Value\Location\Address\StreetSuffix;
use PHPUnit\Framework\TestCase;

final class StreetTest extends TestCase
{
    public function dataFromSingleLine(): \Generator
    {
        yield ['foo 12a', 'foo', '12', 'a'];
        yield ['foo 12 a', 'foo', '12', 'a'];
        yield ['foo 12', 'foo', '12', null];
        yield ['3e Haagstraat 135', '3e Haagstraat', '135', null];
        yield ['3e Haagstraat 135a', '3e Haagstraat', '135', 'a'];
        yield ['33e Haagstraat 135a', '33e Haagstraat', '135', 'a'];
        yield ['27 Kiln Road', 'Kiln Road', '27', null];
        yield ['57065 Pwf Rd', 'Pwf Rd', '57065', null];
        yield ['8122 Thompson Rd.', 'Thompson Rd.', '8122', null];
        yield ['123A đường Lê Lợi', 'đường Lê Lợi', '123', 'A'];
        yield ['Dorp 43 B 3', 'Dorp', '43', 'B 3'];
        yield ['Dendermondsesteenweg 116A Bus 3', 'Dendermondsesteenweg', '116', 'A Bus 3'];
    }

    public function testEquals(): void
    {
        $street = new Street(
            StreetName::fromString('foo'),
            StreetNumber::fromString('12a'),
            StreetSuffix::fromString('bar'),
        );

        self::assertTrue(
            $street->equals(
                new Street(
                    StreetName::fromString('foo'),
                    StreetNumber::fromString('12a'),
                    StreetSuffix::fromString('bar'),
                ),
            ),
        );
        self::assertFalse(
            $street->equals(
                new Street(
                    StreetName::fromString('bar'),
                    StreetNumber::fromString('12a'),
                    StreetSuffix::fromString('bar'),
                ),
            ),
        );
        self::assertFalse(
            $street->equals(
                new Street(
                    StreetName::fromString('foo'),
                    StreetNumber::fromString('12b'),
                    StreetSuffix::fromString('bar'),
                ),
            ),
        );
        self::assertFalse(
            $street->equals(
                new Street(
                    StreetName::fromString('foo'),
                    StreetNumber::fromString('12a'),
                    StreetSuffix::fromString('foo'),
                ),
            ),
        );
        self::assertFalse($street->equals(new Street(StreetName::fromString('foo'), StreetNumber::fromString('12a'))));

        $street = new Street(StreetName::fromString('foo'), StreetNumber::fromString('12a'));

        self::assertTrue($street->equals(new Street(StreetName::fromString('foo'), StreetNumber::fromString('12a'))));
        self::assertFalse($street->equals(new Street(StreetName::fromString('bar'), StreetNumber::fromString('12a'))));
        self::assertFalse($street->equals(new Street(StreetName::fromString('foo'), StreetNumber::fromString('12b'))));
        self::assertFalse(
            $street->equals(
                new Street(
                    StreetName::fromString('foo'),
                    StreetNumber::fromString('12a'),
                    StreetSuffix::fromString('foo'),
                ),
            ),
        );
    }

    /** @dataProvider dataFromSingleLine */
    public function testFromSingleLine(string $line, string $street, string $number, string|null $suffix): void
    {
        self::assertTrue(
            Street::fromSingleLine($line)->equals(
                new Street(
                    StreetName::fromString($street),
                    StreetNumber::fromString($number),
                    null !== $suffix ? StreetSuffix::fromString($suffix) : null,
                ),
            ),
        );
    }

    public function testFromSingleLineFailed(): void
    {
        $this->expectException(InvalidArgument::class);
        Street::fromSingleLine('foo');
    }

    public function testWithSuffix(): void
    {
        $street = new Street(
            $name = StreetName::fromString('foo'),
            $number = StreetNumber::fromString('12a'),
            $suffix = StreetSuffix::fromString('bar'),
        );

        self::assertSame($name, $street->getName());
        self::assertSame($number, $street->getNumber());
        self::assertEquals($suffix, $street->getSuffix());
        self::assertSame('foo 12a bar', (string) $street);
    }

    public function testWithoutSuffix(): void
    {
        $street = new Street(
            $name = StreetName::fromString('foo'),
            $number = StreetNumber::fromString('12a'),
        );

        self::assertSame($name, $street->getName());
        self::assertSame($number, $street->getNumber());
        self::assertNull($street->getSuffix());
        self::assertSame('foo 12a', (string) $street);
    }
}
