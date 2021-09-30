<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Color;

use MyOnlineStore\Common\Domain\Exception\Color\InvalidHexColor;
use MyOnlineStore\Common\Domain\Value\Color\HexColor;
use PHPUnit\Framework\TestCase;

final class HexColorTest extends TestCase
{
    /**
     * @return iterable<array{string}>
     */
    public function invalidStringProvider(): iterable
    {
        yield ['#'];
        yield ['#1'];
        yield ['#12'];
        yield ['#1234'];
        yield ['#12345'];
        yield ['#1234567'];
        yield ['1'];
        yield ['12'];
        yield ['123'];
        yield ['1234'];
        yield ['12345'];
        yield ['123456'];
        yield ['1234567'];
        yield ['#GGGGGG'];
    }

    public function testCreationAndToString(): void
    {
        self::assertEquals(
            '#FFFFFF',
            HexColor::fromString('#fff')
                ->toString()
        );
        self::assertEquals(
            '#FFFFFF',
            HexColor::fromString('#FFFFFF')
                ->toString()
        );
        self::assertEquals(
            '#FFFFFF',
            HexColor::fromString('#ffffff')
                ->toString()
        );
        self::assertEquals(
            '#112233',
            HexColor::fromString('#123')
                ->toString()
        );
    }

    /**
     * @dataProvider invalidStringProvider
     */
    public function testInvalidStringValues(string $value): void
    {
        $this->expectException(InvalidHexColor::class);

        HexColor::fromString($value);
    }
}
