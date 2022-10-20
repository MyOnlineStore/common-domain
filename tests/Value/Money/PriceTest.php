<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Money;

use MyOnlineStore\Common\Domain\Value\Arithmetic\Amount;
use MyOnlineStore\Common\Domain\Value\Money\Price;
use PHPUnit\Framework\TestCase;

final class PriceTest extends TestCase
{
    public function testAbsolute(): void
    {
        self::assertTrue((new Price('0.00'))->equals((new Price('0.00'))->absolute()));
        self::assertTrue((new Price('10.01'))->equals((new Price('10.01'))->absolute()));
        self::assertTrue((new Price('10.01'))->equals((new Price('-10.01'))->absolute()));
    }

    public function testAdd(): void
    {
        self::assertSame('2.000000', (new Price('1'))->add(new Price('1'))->getAmount());
        self::assertSame('2.00', (new Price('1'))->add(new Price('1'), Price::PRECISION_DISPLAY)->getAmount());
        self::assertSame(
            '12425.46',
            (new Price('1.23432423'))->add(new Price('12424.234243'), Price::PRECISION_DISPLAY)->getAmount(),
        );
    }

    public function testAddReturnsNewPriceWithAddedAmounts(): void
    {
        $addedPrice = (new Price(4.04))->add(new Price(5.96));

        self::assertTrue((new Price(10))->equals($addedPrice));
    }

    public function testAsCents(): void
    {
        self::assertSame(8906, (new Price('89.055'))->asCents());
        self::assertSame(8905, (new Price('89.055'))->asCents(\PHP_ROUND_HALF_DOWN));
    }

    public function testAsZero(): void
    {
        self::assertSame('0', (string) Price::asZero());
    }

    public function testComparisons(): void
    {
        $compareSmall = new Price(5.0);
        $compareBig = new Price(10.0);

        self::assertTrue($compareBig->isGreaterThan($compareSmall));
        self::assertTrue($compareSmall->isLessThan($compareBig));
        self::assertTrue($compareBig->equals(new Price(10.0)));
        self::assertTrue($compareBig->isLessThanOrEqualTo(new Price(10.0)));
        self::assertTrue($compareBig->isGreaterThanOrEqualTo(new Price(10.0)));
    }

    public function testCreationEmptyStringBehaviour(): void
    {
        self::assertSame('', (string) new Price(''));
        self::assertSame('', (new Price(''))->getAmount());
    }

    public function testCreationFaultAmount(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Price('blaat');
    }

    public function testDivideByAmountWillReturnPriceDividedByAmount(): void
    {
        self::assertEquals('5.000000', (string) (new Price(10))->divideByAmount(new Amount(2)));
    }

    public function testFromCents(): void
    {
        self::assertSame('1.000000', (string) Price::fromCents(100));
        self::assertSame('0.150000', (string) Price::fromCents(15));
    }

    public function testGetAddedPercentage(): void
    {
        self::assertSame('21.000000', (string) (new Price(121))->getAddedPercentage('21'));
        self::assertSame('1.900411', (string) (new Price('10.95'))->getAddedPercentage('21'));
    }

    public function testGetAmount(): void
    {
        self::assertSame('10.5', (new Price(10.5))->getAmount());
        self::assertSame('10.5', (new Price('10.5'))->getAmount());
        self::assertSame('10.5', (string) new Price('10.5'));
    }

    public function testGetPercentage(): void
    {
        self::assertSame('1.000000', (new Price(100))->getPercentage('1')->getAmount());
    }

    public function testGetRoundedAmountReturnsPriceWithRequestedNumberOfDecimals(): void
    {
        self::assertSame('12345.90', (string) (new Price(12345.8998))->round(2));
        self::assertSame('12.904', (string) (new Price(12.90390))->round(3));
    }

    public function testIsPositive(): void
    {
        self::assertTrue((new Price(10.5))->isPositive());
        self::assertFalse((new Price(-10.5))->isPositive());
        self::assertFalse((new Price(-10.5))->isZero());
        self::assertTrue((new Price(-10.5))->isNegative());
    }

    public function testMultiplyReturnsNewPriceWithDividedAmounts(): void
    {
        $dividedPrice = (new Price(\M_PI))->divideBy(new Price(2));

        self::assertEquals(0, \strncmp((string) new Price(\M_PI_2), (string) $dividedPrice, Price::PRECISION_CALC));
    }

    public function testMultiplyReturnsNewPriceWithMultipliedAmounts(): void
    {
        $multipliedPrice = (new Price(\M_PI_2))->multiplyBy(new Price(2));

        self::assertEquals(0, \strncmp((string) new Price(\M_PI), (string) $multipliedPrice, Price::PRECISION_CALC));
    }

    public function testMultiplyByAmount(): void
    {
        $multipliedPrice = (new Price(\M_PI_2))->multiplyByAmount(new Amount(2));

        self::assertEquals(0, \strncmp((string) new Price(\M_PI), (string) $multipliedPrice, Price::PRECISION_CALC));
    }

    public function testPercentageCalculations(): void
    {
        self::assertSame('9.459459', (new Price(10.5))->subtractPercentage('11')->getAmount());
        self::assertSame('11.655000', (new Price(10.5))->addPercentage('11')->getAmount());
    }

    public function testSubtraction(): void
    {
        self::assertSame('5.000000', (new Price(10))->subtract(new Price(5))->getAmount());
    }
}
