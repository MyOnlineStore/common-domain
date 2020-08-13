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
    public function testEquals(): void
    {
        $street = new Street(
            StreetName::fromString('foo'),
            StreetNumber::fromString('12a'),
            StreetSuffix::fromString('bar')
        );

        self::assertTrue(
            $street->equals(
                new Street(
                    StreetName::fromString('foo'),
                    StreetNumber::fromString('12a'),
                    StreetSuffix::fromString('bar')
                )
            )
        );
        self::assertFalse(
            $street->equals(
                new Street(
                    StreetName::fromString('bar'),
                    StreetNumber::fromString('12a'),
                    StreetSuffix::fromString('bar')
                )
            )
        );
        self::assertFalse(
            $street->equals(
                new Street(
                    StreetName::fromString('foo'),
                    StreetNumber::fromString('12b'),
                    StreetSuffix::fromString('bar')
                )
            )
        );
        self::assertFalse(
            $street->equals(
                new Street(
                    StreetName::fromString('foo'),
                    StreetNumber::fromString('12a'),
                    StreetSuffix::fromString('foo')
                )
            )
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
                    StreetSuffix::fromString('foo')
                )
            )
        );
    }

    public function testFromSingleLine(): void
    {
        self::assertTrue(
            Street::fromSingleLine('foo 12a')->equals(
                new Street(
                    StreetName::fromString('foo'),
                    StreetNumber::fromString('12'),
                    StreetSuffix::fromString('a')
                )
            )
        );
        self::assertTrue(
            Street::fromSingleLine('foo 12 a')->equals(
                new Street(
                    StreetName::fromString('foo'),
                    StreetNumber::fromString('12'),
                    StreetSuffix::fromString('a')
                )
            )
        );
        self::assertTrue(
            Street::fromSingleLine('foo 12')->equals(
                new Street(
                    StreetName::fromString('foo'),
                    StreetNumber::fromString('12')
                )
            )
        );
        self::assertTrue(
            Street::fromSingleLine('3e Haagstraat 135')->equals(
                new Street(
                    StreetName::fromString('3e Haagstraat'),
                    StreetNumber::fromString('135')
                )
            )
        );
        self::assertTrue(
            Street::fromSingleLine('3e Haagstraat 135a')->equals(
                new Street(
                    StreetName::fromString('3e Haagstraat'),
                    StreetNumber::fromString('135'),
                    StreetSuffix::fromString('a')
                )
            )
        );
    }

    public function testFromSingleLineFailed(): void
    {
        $this->expectException(InvalidArgument::class);
        Street::fromSingleLine('foo');
    }

    public function testWithoutSuffix(): void
    {
        $street = new Street(
            $name = StreetName::fromString('foo'),
            $number = StreetNumber::fromString('12a')
        );

        self::assertSame($name, $street->getName());
        self::assertSame($number, $street->getNumber());
        self::assertNull($street->getSuffix());
        self::assertSame('foo 12a', (string) $street);
    }

    public function testWithSuffix(): void
    {
        $street = new Street(
            $name = StreetName::fromString('foo'),
            $number = StreetNumber::fromString('12a'),
            $suffix = StreetSuffix::fromString('bar')
        );

        self::assertSame($name, $street->getName());
        self::assertSame($number, $street->getNumber());
        self::assertEquals($suffix, $street->getSuffix());
        self::assertSame('foo 12a bar', (string) $street);
    }
}
