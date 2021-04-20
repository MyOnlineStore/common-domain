<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Contact;

use MyOnlineStore\Common\Domain\Exception\Contact\InvalidPhoneNumber;
use MyOnlineStore\Common\Domain\Value\Contact\PhoneNumber;
use MyOnlineStore\Common\Domain\Value\RegionCode;
use PHPUnit\Framework\TestCase;

final class PhoneNumberTest extends TestCase
{
    /**
     * @return string[][]
     */
    public function getInvalidStringValues(): array
    {
        return [
            ['+313'],
            ['1'],
            ['0013'],
            ['dgdgffdg'],
        ];
    }

    /**
     * @return string[][]
     */
    public function getValidStringValues(): array
    {
        return [
            ['0031882315726'],
            ['+31 (0)412 66 80 11'],
            ['+32 0412 66 80 11'],
            ['+32 412 66 80 11'],
            ['0612483496'],
            ['112'],
        ];
    }

    /**
     * @return mixed[][]
     */
    public function shortInternationalFormatProvider(): array
    {
        return [
            ['+321882315726', new PhoneNumber('1882315726', RegionCode::fromString('BE'))],
            ['+31412668011', new PhoneNumber('+31 (0)412 66 80 11', RegionCode::fromString('NL'))],
            ['+32412668011', new PhoneNumber('+32 0412 66 80 11', RegionCode::fromString('NL'))],
            ['+32412668011', new PhoneNumber('+32 412 66 80 11', RegionCode::fromString('NL'))],
            ['+31612483496', new PhoneNumber('0612483496', RegionCode::fromString('NL'))],
            ['+10612483496', new PhoneNumber('0612483496', RegionCode::fromString('US'))],
            ['+31112', new PhoneNumber('112', RegionCode::fromString('NL'))],
        ];
    }

    /**
     * @return mixed[][]
     */
    public function equalPhoneNumberProvider(): array
    {
        return [
            [false, new PhoneNumber('0031612483496', RegionCode::fromString('NL')), new PhoneNumber('0031612483497', RegionCode::fromString('NL'))],
            [false, new PhoneNumber('003232364627', RegionCode::fromString('NL')), new PhoneNumber('03 236 46 27', RegionCode::fromString('NL'))],
            [true, new PhoneNumber('0031612483496', RegionCode::fromString('NL')), new PhoneNumber('0612483496', RegionCode::fromString('NL'))],
            [true, new PhoneNumber('0031612483496', RegionCode::fromString('NL')), new PhoneNumber('06 12 48 34 96', RegionCode::fromString('NL'))],
            [true, new PhoneNumber('0031612483496', RegionCode::fromString('NL')), new PhoneNumber('+31 (0)6 12 48 34 96', RegionCode::fromString('NL'))],
        ];
    }

    /**
     * @dataProvider equalPhoneNumberProvider
     */
    public function testEqualsWillReturnFormatterEquality(
        bool $expectedResult,
        PhoneNumber $phoneNumber,
        PhoneNumber $otherNumber
    ): void {
        self::assertEquals($expectedResult, $phoneNumber->equals($otherNumber));
    }

    public function testFormatted(): void
    {
        self::assertEquals('0031882315726', (new PhoneNumber('0031882315726', RegionCode::fromString('NL')))->getFormatted());
        self::assertEquals('0031412668011', (new PhoneNumber('+31 (0)412 66 80 11', RegionCode::fromString('NL')))->getFormatted());
        self::assertEquals('0032412668011', (new PhoneNumber('+32 0412 66 80 11', RegionCode::fromString('NL')))->getFormatted());
        self::assertEquals('0032412668011', (new PhoneNumber('+32 412 66 80 11', RegionCode::fromString('NL')))->getFormatted());
        self::assertEquals('0031612483496', (new PhoneNumber('0612483496', RegionCode::fromString('NL')))->getFormatted());
        self::assertEquals('0031112', (new PhoneNumber('112', RegionCode::fromString('NL')))->getFormatted());
    }

    public function testGetCountryCode(): void
    {
        self::assertEquals(31, (new PhoneNumber('0031882315726', RegionCode::fromString('NL')))->getCountryCode());
        self::assertEquals(31, (new PhoneNumber('+31 (0)412 66 80 11', RegionCode::fromString('NL')))->getCountryCode());
        self::assertEquals(32, (new PhoneNumber('+32 412 66 80 11', RegionCode::fromString('NL')))->getCountryCode());
    }

    public function testWithRegionCodeChangesCountryPrefix(): void
    {
        $phoneNumber = new PhoneNumber('0031882315726', RegionCode::fromString('NL'));

        self::assertEquals('+31882315726', $phoneNumber->toString());
        self::assertEquals('+32882315726', $phoneNumber->withRegionCode(RegionCode::fromString('BE'))->toString());
        self::assertEquals('+49882315726', $phoneNumber->withRegionCode(RegionCode::fromString('DE'))->toString());
        self::assertEquals('+44882315726', $phoneNumber->withRegionCode(RegionCode::fromString('GB'))->toString());
    }

    /**
     * @dataProvider shortInternationalFormatProvider
     */
    public function testShortInternationalFormat(string $expectedFormat, PhoneNumber $phoneNumber): void
    {
        self::assertEquals($expectedFormat, $phoneNumber->getShortInternationalFormat());
    }

    /**
     * @dataProvider getInvalidStringValues
     */
    public function testInvalidStringValues(string $value): void
    {
        $this->expectException(InvalidPhoneNumber::class);

        new PhoneNumber($value, RegionCode::fromString('NL'));
    }

    public function testIsFixedLine(): void
    {
        self::assertTrue((new PhoneNumber('0031132315726', RegionCode::fromString('NL')))->isFixedLine());
        self::assertTrue((new PhoneNumber('+31 (0)412 66 80 11', RegionCode::fromString('NL')))->isFixedLine());
        self::assertTrue((new PhoneNumber('+31 412 66 80 11', RegionCode::fromString('NL')))->isFixedLine());
        self::assertFalse((new PhoneNumber('0612483496', RegionCode::fromString('NL')))->isFixedLine());
        self::assertFalse((new PhoneNumber('+447134567575', RegionCode::fromString('NL')))->isFixedLine());
    }

    public function testIsMobile(): void
    {
        self::assertFalse((new PhoneNumber('0031882315726', RegionCode::fromString('NL')))->isMobile());
        self::assertFalse((new PhoneNumber('+31 (0)412 66 80 11', RegionCode::fromString('NL')))->isMobile());
        self::assertFalse((new PhoneNumber('+32 0412 66 80 11', RegionCode::fromString('NL')))->isMobile());
        self::assertFalse((new PhoneNumber('+32 412 66 80 11', RegionCode::fromString('NL')))->isMobile());
        self::assertTrue((new PhoneNumber('0612483496', RegionCode::fromString('NL')))->isMobile());
        self::assertTrue((new PhoneNumber('+447134567575', RegionCode::fromString('NL')))->isMobile());
        self::assertFalse((new PhoneNumber('112', RegionCode::fromString('NL')))->isMobile());
    }

    public function testToString(): void
    {
        $phoneNumber = new PhoneNumber('0031882315726', RegionCode::fromString('NL'));
        self::assertEquals($phoneNumber->getShortInternationalFormat(), $phoneNumber->toString());
    }

    /**
     * @dataProvider getValidStringValues
     */
    public function testValidStringValues(string $value): void
    {
        self::assertInstanceOf(PhoneNumber::class, new PhoneNumber($value, RegionCode::fromString('NL')));
    }
}
