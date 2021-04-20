<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value;

use MyOnlineStore\Common\Domain\Exception\InvalidArgument;
use MyOnlineStore\Common\Domain\Value\RegionCode;
use PHPUnit\Framework\TestCase;

final class RegionCodeTest extends TestCase
{
    public function testEquals(): void
    {
        $regionCode = RegionCode::fromString('NL');
        self::assertTrue($regionCode->equals(RegionCode::fromString('nl')));
        self::assertFalse($regionCode->equals(RegionCode::fromString('DE')));
    }

    /**
     * @dataProvider invalidArgumentProvider
     */
    public function testInvalidTypes(string $argument): void
    {
        $this->expectException(InvalidArgument::class);
        RegionCode::fromString($argument);
    }

    public function testToString(): void
    {
        self::assertEquals('NL', RegionCode::fromString('NL')->toString());
        self::assertEquals('NL', RegionCode::fromString('nl')->toString());
        self::assertEquals('DE', RegionCode::fromString('DE')->toString());
    }

    public function testToLower(): void
    {
        self::assertEquals('nl', RegionCode::fromString('NL')->lower());
        self::assertEquals('nl', RegionCode::fromString('nl')->lower());
        self::assertEquals('de', RegionCode::fromString('DE')->lower());
    }

    /**
     * @return list<list<string>>
     */
    public function invalidArgumentProvider(): array
    {
        return [
            ['N'],
            ['Nld'],
            ['NLD'],
        ];
    }

    /**
     * @return \Generator<array{RegionCode, bool}>
     */
    public function isEuRegionProvider(): \Generator
    {
        yield [RegionCode::fromString('AT'), true];
        yield [RegionCode::fromString('BE'), true];
        yield [RegionCode::fromString('BG'), true];
        yield [RegionCode::fromString('CY'), true];
        yield [RegionCode::fromString('CZ'), true];
        yield [RegionCode::fromString('DE'), true];
        yield [RegionCode::fromString('DK'), true];
        yield [RegionCode::fromString('EE'), true];
        yield [RegionCode::fromString('ES'), true];
        yield [RegionCode::fromString('FI'), true];
        yield [RegionCode::fromString('FR'), true];
        yield [RegionCode::fromString('GR'), true];
        yield [RegionCode::fromString('HU'), true];
        yield [RegionCode::fromString('IE'), true];
        yield [RegionCode::fromString('IT'), true];
        yield [RegionCode::fromString('HR'), true];
        yield [RegionCode::fromString('LT'), true];
        yield [RegionCode::fromString('LU'), true];
        yield [RegionCode::fromString('LV'), true];
        yield [RegionCode::fromString('MT'), true];
        yield [RegionCode::fromString('NL'), true];
        yield [RegionCode::fromString('PL'), true];
        yield [RegionCode::fromString('PT'), true];
        yield [RegionCode::fromString('RO'), true];
        yield [RegionCode::fromString('SE'), true];
        yield [RegionCode::fromString('SI'), true];
        yield [RegionCode::fromString('SK'), true];
        yield [RegionCode::fromString('AG'), false];
        yield [RegionCode::fromString('CH'), false];
        yield [RegionCode::fromString('GB'), false];
    }

    /**
     * @dataProvider isEuRegionProvider
     */
    public function testIsEuRegion(RegionCode $regionCode, bool $expected): void
    {
        self::assertSame($expected, $regionCode->isEuRegion());
    }
}
