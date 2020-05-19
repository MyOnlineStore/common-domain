<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Location\Address;

use MyOnlineStore\Common\Domain\Value\Location\Address\Street;
use MyOnlineStore\Common\Domain\Value\Location\Address\StreetName;
use MyOnlineStore\Common\Domain\Value\Location\Address\StreetNumber;
use MyOnlineStore\Common\Domain\Value\Location\Address\StreetSuffix;
use PHPUnit\Framework\TestCase;

final class StreetTest extends TestCase
{
    public function testWithoutSuffix(): void
    {
        $street = new Street(
            $name = StreetName::fromString('foo'),
            $number = StreetNumber::fromString('12a')
        );

        self::assertSame($name, $street->getName());
        self::assertSame($number, $street->getNumber());
        self::assertNull($street->getSuffix());
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
        self::assertSame($suffix, $street->getSuffix());
    }
}
