<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value;

use MyOnlineStore\Common\Domain\Exception\InvalidArgument;
use MyOnlineStore\Common\Domain\Value\LanguageCode;
use PHPUnit\Framework\TestCase;

final class LanguageCodeTest extends TestCase
{
    /** @dataProvider invalidArgumentProvider */
    public function testInvalidTypes(string $argument): void
    {
        $this->expectException(InvalidArgument::class);
        new LanguageCode($argument);
    }

    public function testToString(): void
    {
        self::assertEquals('nl', (string) new LanguageCode('nl'));
        self::assertEquals('nl', (string) new LanguageCode('NL'));
        self::assertEquals('moh', (string) new LanguageCode('MoH'));
    }

    public function testEqual(): void
    {
        self::assertTrue((new LanguageCode('nl'))->equals(new LanguageCode('nl')));
        self::assertFalse((new LanguageCode('nl'))->equals(new LanguageCode('en')));
    }

    /** @return string[][] */
    public function invalidArgumentProvider(): array
    {
        return [
            ['n'],
            ['nederland'],
        ];
    }
}
