<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value;

use MyOnlineStore\Common\Domain\Exception\InvalidArgument;
use MyOnlineStore\Common\Domain\Value\LanguageCode;
use PHPUnit\Framework\TestCase;

final class LanguageCodeTest extends TestCase
{
    /**
     * @dataProvider invalidArgumentProvider
     */
    public function testInvalidTypes(string $argument): void
    {
        $this->expectException(InvalidArgument::class);
        LanguageCode::fromString($argument);
    }

    public function testToString(): void
    {
        self::assertEquals('nl', LanguageCode::fromString('nl')->toString());
        self::assertEquals('nl', LanguageCode::fromString('NL')->toString());
        self::assertEquals('moh', LanguageCode::fromString('MoH')->toString());
    }

    public function testEqual(): void
    {
        self::assertTrue(LanguageCode::fromString('nl')->equals(LanguageCode::fromString('nl')));
        self::assertFalse(LanguageCode::fromString('nl')->equals(LanguageCode::fromString('en')));
    }

    /**
     * @return string[][]
     */
    public function invalidArgumentProvider(): array
    {
        return [
            ['n'],
            ['nederland'],
        ];
    }
}
