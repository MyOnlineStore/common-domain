<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Money;

use MyOnlineStore\Common\Domain\Value\Arithmetic\Amount;
use MyOnlineStore\Common\Domain\Value\Money\CurrencyIso;
use MyOnlineStore\Common\Domain\Value\Money\Money;
use PHPUnit\Framework\TestCase;

final class MoneyTest extends TestCase
{
    /**
     * @return mixed[]
     */
    public function fractionedArgumentProvider(): array
    {
        return [
            ['131231', CurrencyIso::fromString('EUR'), '131231.00', 13123100],
            ['464.4534', CurrencyIso::fromString('EUR'), '464.45', 46445],
            ['-23123.23', CurrencyIso::fromString('EUR'), '-23123.23', -2312323],
            ['0.2323232', CurrencyIso::fromString('USD'), '0.23', 23],
            ['2323232', CurrencyIso::fromString('XXX'), '2323232', 2323232],
            ['232.3232', CurrencyIso::fromString('IQD'), '232.323', 232323],
            ['11.999998', CurrencyIso::fromString('EUR'), '12.00', 1200],
        ];
    }

    public function testAdd(): void
    {
        $money1 = new Money(new Amount(123), CurrencyIso::fromString('EUR'));
        $money2 = new Money(new Amount(321), CurrencyIso::fromString('EUR'));

        self::assertEquals(new Money(new Amount(444), CurrencyIso::fromString('EUR')), $money1->add($money2));
    }

    public function testAddWithMixedCurrencies(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new Money(Amount::asZero(), CurrencyIso::fromString('EUR')))
            ->add(new Money(Amount::asZero(), CurrencyIso::fromString('USD')));
    }

    public function testEquals(): void
    {
        $money = new Money(new Amount('123'), CurrencyIso::fromString('EUR'));

        self::assertTrue($money->equals(new Money(new Amount('123'), CurrencyIso::fromString('EUR'))));
        self::assertFalse($money->equals(new Money(new Amount('456'), CurrencyIso::fromString('EUR'))));
        self::assertFalse($money->equals(new Money(new Amount('123'), CurrencyIso::fromString('USD'))));
        self::assertFalse($money->equals(new Money(new Amount('456'), CurrencyIso::fromString('USD'))));
    }

    public function testFromFractionWithCommaSeparatorWillThrowException(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Money::fromFractionated('34535,34', CurrencyIso::fromString('USD'));
    }

    /**
     * @dataProvider fractionedArgumentProvider
     *
     * @param mixed $amount
     */
    public function testFromFractioned($amount, CurrencyIso $currency, string $expectedString, int $expectedWhole): void
    {
        $money = Money::fromFractionated($amount, $currency);
        self::assertEquals($expectedString, (string) $money);
        self::assertEquals($expectedWhole, (string) $money->getAmount());
        self::assertSame($currency, $money->getCurrency());
    }

    /**
     * @dataProvider wholeArgumentProvider
     *
     * @param mixed $amount
     */
    public function testFromWhole($amount, CurrencyIso $currency, string $expectedString, int $expectedWhole): void
    {
        $money = new Money($amount, $currency);
        self::assertEquals($expectedString, (string) $money);
        self::assertEquals($expectedWhole, (string) $money->getAmount());
        self::assertSame($currency, $money->getCurrency());
    }

    /**
     * @return mixed[]
     */
    public function wholeArgumentProvider(): array
    {
        return [
            [new Amount('131231'), CurrencyIso::fromString('EUR'), '1312.31', 131231],
            [new Amount('-23123'), CurrencyIso::fromString('EUR'), '-231.23', -23123],
            [new Amount('02323232'), CurrencyIso::fromString('USD'), '23232.32', 2323232],
            [new Amount('1337'), CurrencyIso::fromString('XXX'), '1337', 1337],
            [new Amount('-1337'), CurrencyIso::fromString('IQD'), '-1.337', -1337],
        ];
    }
}
