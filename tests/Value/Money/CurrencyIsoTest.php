<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Money;

use MyOnlineStore\Common\Domain\Exception\Currency\InvalidCurrencyIso;
use MyOnlineStore\Common\Domain\Value\Money\CurrencyIso;
use PHPUnit\Framework\TestCase;

final class CurrencyIsoTest extends TestCase
{
    public function testAgainstMoneyPhpCurrency(): void
    {
        $currencies = require __DIR__.'/../../../vendor/moneyphp/money/resources/currency.php';

        foreach ($currencies as $code => $currency) {
            $currencyIso = CurrencyIso::fromString($code);

            self::assertSame($currency['alphabeticCode'], $currencyIso->__toString());
            self::assertSame($currency['minorUnit'], $currencyIso->getMinorUnit());
        }
    }

    public function testEquals(): void
    {
        self::assertTrue(
            CurrencyIso::fromString('OMR')->equals(
                CurrencyIso::fromString('OMR')
            )
        );
        self::assertFalse(CurrencyIso::fromString('OMR')->equals(
            CurrencyIso::fromString('EUR')
        ));
    }

    /**
     * @dataProvider invalidArgumentProvider
     */
    public function testInvalidTypes(string $argument): void
    {
        $this->expectException(InvalidCurrencyIso::class);
        CurrencyIso::fromString($argument);
    }

    public function testGetMinorUnit(): void
    {
        self::assertEquals(3, CurrencyIso::fromString('OMR')->getMinorUnit());
        self::assertEquals(2, CurrencyIso::fromString('EUR')->getMinorUnit());
        self::assertEquals(2, CurrencyIso::fromString('USD')->getMinorUnit());
        self::assertEquals(0, CurrencyIso::fromString('JPY')->getMinorUnit());
    }

    public function testToString(): void
    {
        self::assertEquals('EUR', (string) CurrencyIso::fromString('EUR'));
        self::assertEquals('USD', (string) CurrencyIso::fromString('USD'));
        self::assertEquals('JPY', (string) CurrencyIso::fromString('JPY'));
    }

    /**
     * @return string[][]
     */
    public function invalidArgumentProvider(): array
    {
        return [
            ['EU'],
            ['eur'],
            ['EUr'],
            ['EURO'],
        ];
    }
}
