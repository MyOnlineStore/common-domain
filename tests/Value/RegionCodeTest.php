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
        $regionCode = RegionCode::asNL();
        self::assertTrue($regionCode->equals(new RegionCode('nl')));
        self::assertFalse($regionCode->equals(new RegionCode('DE')));
    }

    /**
     * @dataProvider invalidArgumentProvider
     */
    public function testInvalidTypes(?string $argument): void
    {
        $this->expectException(InvalidArgument::class);
        new RegionCode($argument);
    }

    public function testToString(): void
    {
        self::assertEquals('NL', (string) RegionCode::asNL());
        self::assertEquals('NL', (string) new RegionCode('nl'));
        self::assertEquals('DE', (string) new RegionCode('DE'));
    }

    public function testToLower(): void
    {
        self::assertEquals('nl', RegionCode::asNL()->lower());
        self::assertEquals('nl', (new RegionCode('nl'))->lower());
        self::assertEquals('de', (new RegionCode('DE'))->lower());
    }

    /**
     * @return string[][]|null[][]
     */
    public function invalidArgumentProvider(): array
    {
        return [
            ['N'],
            ['Nld'],
            ['NLD'],
            [null],
        ];
    }

    /**
     * @return \Generator<array{RegionCode, bool}>
     */
    public function isEuRegionProvider(): \Generator
    {
        yield [new RegionCode('AT'), true];
        yield [new RegionCode('BE'), true];
        yield [new RegionCode('BG'), true];
        yield [new RegionCode('CY'), true];
        yield [new RegionCode('CZ'), true];
        yield [new RegionCode('DE'), true];
        yield [new RegionCode('DK'), true];
        yield [new RegionCode('EE'), true];
        yield [new RegionCode('ES'), true];
        yield [new RegionCode('FI'), true];
        yield [new RegionCode('FR'), true];
        yield [new RegionCode('GR'), true];
        yield [new RegionCode('HU'), true];
        yield [new RegionCode('IE'), true];
        yield [new RegionCode('IT'), true];
        yield [new RegionCode('HR'), true];
        yield [new RegionCode('LT'), true];
        yield [new RegionCode('LU'), true];
        yield [new RegionCode('LV'), true];
        yield [new RegionCode('MT'), true];
        yield [new RegionCode('NL'), true];
        yield [new RegionCode('PL'), true];
        yield [new RegionCode('PT'), true];
        yield [new RegionCode('RO'), true];
        yield [new RegionCode('SE'), true];
        yield [new RegionCode('SI'), true];
        yield [new RegionCode('SK'), true];
        yield [new RegionCode('AG'), false];
        yield [new RegionCode('CH'), false];
        yield [new RegionCode('GB'), false];
    }

    /**
     * @dataProvider isEuRegionProvider
     */
    public function testIsEuRegion(RegionCode $regionCode, bool $expected): void
    {
        self::assertEquals($expected, $regionCode->isEuRegion());
    }
}
