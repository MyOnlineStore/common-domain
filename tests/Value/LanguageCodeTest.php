<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value;

use MyOnlineStore\Common\Domain\Value\LanguageCode;

final class LanguageCodeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider invalidArgumentProvider
     * @expectedException \InvalidArgumentException
     *
     * @param mixed $argument
     */
    public function testInvalidTypes($argument)
    {
        new LanguageCode($argument);
    }

    public function testToString()
    {
        self::assertEquals('nl', (string) new LanguageCode('nl'));
        self::assertEquals('nl', (string) new LanguageCode('NL'));
        self::assertEquals('moh', (string) new LanguageCode('MoH'));
    }

    public function testEqual()
    {
        self::assertTrue((new LanguageCode('nl'))->equals(new LanguageCode('nl')));
        self::assertFalse((new LanguageCode('nl'))->equals(new LanguageCode('en')));
    }

    /**
     * @return array[]
     */
    public function invalidArgumentProvider()
    {
        return [
            ['n'],
            ['nederland']
        ];
    }
}
