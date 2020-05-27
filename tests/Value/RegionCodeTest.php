<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value;

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
     *
     * @param mixed $argument
     */
    public function testInvalidTypes($argument): void
    {
        $this->expectException('InvalidArgumentException');
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
     * @return array[]
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
     * @return array[]
     */
    public function isEuRegionProvider(): array
    {
        return [
            [RegionCode::asNL(), true],
            [new RegionCode('BE'), true],
            [new RegionCode('AG'), false],
            [new RegionCode('CH'), false],
        ];
    }

    /**
     * @dataProvider isEuRegionProvider
     *
     */
    public function testIsEuRegion(RegionCode $regionCode, bool $expected): void
    {
        $this->assertEquals($expected, $regionCode->isEuRegion());
    }
}
