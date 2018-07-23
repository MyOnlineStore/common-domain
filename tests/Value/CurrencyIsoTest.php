<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value;

use MyOnlineStore\Common\Domain\Value\CurrencyIso;

final class CurrencyIsoTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @return array[]
     */
    public function invalidArgumentProvider()
    {
        return [
            [123],
            ['EU'],
            ['eur'],
            ['EUr'],
            ['EURO'],
        ];
    }

    public function testGetMinorUnit()
    {
        self::assertEquals(3, (new CurrencyIso('OMR'))->getMinorUnit());
        self::assertEquals(2, (new CurrencyIso('EUR'))->getMinorUnit());
        self::assertEquals(2, (new CurrencyIso('USD'))->getMinorUnit());
        self::assertEquals(0, (new CurrencyIso('JPY'))->getMinorUnit());
    }

    /**
     * @dataProvider invalidArgumentProvider
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
}
