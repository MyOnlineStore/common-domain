<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Contact;

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
            ['+321882315726', new PhoneNumber('1882315726', new RegionCode('BE'))],
            ['+31412668011', new PhoneNumber('+31 (0)412 66 80 11')],
            ['+32412668011', new PhoneNumber('+32 0412 66 80 11')],
            ['+32412668011', new PhoneNumber('+32 412 66 80 11')],
            ['+31612483496', new PhoneNumber('0612483496')],
            ['+10612483496', new PhoneNumber('0612483496', new RegionCode('US'))],
            ['+31112', new PhoneNumber('112')],
        ];
    }

    /**
     * @return mixed[][]
     */
    public function equalPhoneNumberProvider(): array
    {
        return [
            [false, new PhoneNumber('0031612483496'), new PhoneNumber('0031612483497')],
            [false, new PhoneNumber('003232364627'), new PhoneNumber('03 236 46 27')],
            [true, new PhoneNumber('0031612483496'), new PhoneNumber('0612483496')],
            [true, new PhoneNumber('0031612483496'), new PhoneNumber('06 12 48 34 96')],
            [true, new PhoneNumber('0031612483496'), new PhoneNumber('+31 (0)6 12 48 34 96')],
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
        self::assertEquals('0031882315726', (new PhoneNumber('0031882315726'))->getFormatted());
        self::assertEquals('0031412668011', (new PhoneNumber('+31 (0)412 66 80 11'))->getFormatted());
        self::assertEquals('0032412668011', (new PhoneNumber('+32 0412 66 80 11'))->getFormatted());
        self::assertEquals('0032412668011', (new PhoneNumber('+32 412 66 80 11'))->getFormatted());
        self::assertEquals('0031612483496', (new PhoneNumber('0612483496'))->getFormatted());
        self::assertEquals('0031112', (new PhoneNumber('112'))->getFormatted());
    }

    public function testGetCountryCode(): void
    {
        self::assertEquals(31, (new PhoneNumber('0031882315726'))->getCountryCode());
        self::assertEquals(31, (new PhoneNumber('+31 (0)412 66 80 11'))->getCountryCode());
        self::assertEquals(32, (new PhoneNumber('+32 412 66 80 11'))->getCountryCode());
    }

    public function testWithRegionCodeChangesCountryPrefix(): void
    {
        $phoneNumber = new PhoneNumber('0031882315726');

        self::assertEquals('+31882315726', (string) $phoneNumber);
        self::assertEquals('+32882315726', (string) $phoneNumber->withRegionCode(new RegionCode('BE')));
        self::assertEquals('+49882315726', (string) $phoneNumber->withRegionCode(new RegionCode('DE')));
        self::assertEquals('+44882315726', (string) $phoneNumber->withRegionCode(new RegionCode('GB')));
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
        $this->expectException(\InvalidArgumentException::class);

        new PhoneNumber($value);
    }

    public function testIsFixedLine(): void
    {
        self::assertTrue((new PhoneNumber('0031132315726'))->isFixedLine());
        self::assertTrue((new PhoneNumber('+31 (0)412 66 80 11'))->isFixedLine());
        self::assertTrue((new PhoneNumber('+31 412 66 80 11'))->isFixedLine());
        self::assertFalse((new PhoneNumber('0612483496'))->isFixedLine());
        self::assertFalse((new PhoneNumber('+447134567575'))->isFixedLine());
    }

    public function testIsMobile(): void
    {
        self::assertFalse((new PhoneNumber('0031882315726'))->isMobile());
        self::assertFalse((new PhoneNumber('+31 (0)412 66 80 11'))->isMobile());
        self::assertFalse((new PhoneNumber('+32 0412 66 80 11'))->isMobile());
        self::assertFalse((new PhoneNumber('+32 412 66 80 11'))->isMobile());
        self::assertTrue((new PhoneNumber('0612483496'))->isMobile());
        self::assertTrue((new PhoneNumber('+447134567575'))->isMobile());
        self::assertFalse((new PhoneNumber('112'))->isMobile());
    }

    public function testStringConversion(): void
    {
        $phoneNumber = PhoneNumber::fromString('0031882315726');
        self::assertEquals($phoneNumber->getShortInternationalFormat(), (string) $phoneNumber);
    }

    /**
     * @dataProvider getValidStringValues
     */
    public function testValidStringValues(string $value): void
    {
        self::assertInstanceOf(PhoneNumber::class, new PhoneNumber($value));
    }
}
