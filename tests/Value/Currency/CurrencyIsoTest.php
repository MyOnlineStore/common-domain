<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Currency;

use MyOnlineStore\Common\Domain\Value\Currency\CurrencyIso;
use PHPUnit\Framework\TestCase;

class CurrencyIsoTest extends TestCase
{
    /**
     * @dataProvider invalidArgumentProvider
     *
     * @expectedException \InvalidArgumentException
     *
     * @param mixed $argument
     */
    public function testInvalidTypes($argument)
    {
        new CurrencyIso($argument);
    }

    public function testToString()
    {
        self::assertEquals('EUR', (string) new CurrencyIso('EUR'));
        self::assertEquals('USD', (string) new CurrencyIso('USD'));
        self::assertEquals('JPY', (string) new CurrencyIso('JPY'));
    }

    public function testGetMinorUnit()
    {
        self::assertEquals(3, (new CurrencyIso('OMR'))->getMinorUnit());
        self::assertEquals(2, (new CurrencyIso('EUR'))->getMinorUnit());
        self::assertEquals(2, (new CurrencyIso('USD'))->getMinorUnit());
        self::assertEquals(0, (new CurrencyIso('JPY'))->getMinorUnit());
    }

    /**
     * @return string[][]|int[][]
     */
    public function invalidArgumentProvider(): array
    {
        return [
            [123],
            ['EU'],
            ['eur'],
            ['EUr'],
            ['EURO'],
        ];
    }
}
