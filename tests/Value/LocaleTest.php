<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value;

use MyOnlineStore\Common\Domain\Exception\InvalidArgument;
use MyOnlineStore\Common\Domain\Value\LanguageCode;
use MyOnlineStore\Common\Domain\Value\Locale;
use MyOnlineStore\Common\Domain\Value\RegionCode;
use PHPUnit\Framework\TestCase;

final class LocaleTest extends TestCase
{
    public function testEquals(): void
    {
        self::assertTrue(Locale::fromString('nl_NL')->equals(Locale::fromString('nl_NL')));
        self::assertFalse(Locale::fromString('nl_BE')->equals(Locale::fromString('nl_NL')));
    }

    /**
     * @dataProvider invalidArgumentProvider
     */
    public function testFromInvalidString(string $argument): void
    {
        $this->expectException(InvalidArgument::class);
        Locale::fromString($argument);
    }

    public function testFromString(): void
    {
        $locale = Locale::fromString('nl_NL');

        self::assertEquals(RegionCode::fromString('NL'), $locale->regionCode);
        self::assertEquals(LanguageCode::fromString('nl'), $locale->languageCode);
    }

    public function testFromStringCaseInsensitive(): void
    {
        $locale = Locale::fromString('DE_de');

        self::assertEquals(RegionCode::fromString('DE'), $locale->regionCode);
        self::assertEquals(LanguageCode::fromString('de'), $locale->languageCode);
    }

    public function testToString(): void
    {
        self::assertSame('nl_NL', Locale::fromString('nl_NL')->toString());
        self::assertSame('moh_CA', Locale::fromString('moh_CA')->toString());
    }

    public function testLanguageCode(): void
    {
        self::assertEquals(LanguageCode::fromString('fr'), Locale::fromString('fr_BE')->languageCode);
        self::assertEquals(LanguageCode::fromString('nl'), Locale::fromString('nl_BE')->languageCode);
    }

    public function testRegionCode(): void
    {
        self::assertEquals(RegionCode::fromString('NL'), Locale::fromString('nl_NL')->regionCode);
        self::assertEquals(RegionCode::fromString('DE'), Locale::fromString('de_DE')->regionCode);
    }

    /**
     * @return list<list<string>>
     */
    public function invalidArgumentProvider(): array
    {
        return [
            ['ca_MOH'],
            ['nl'],
            ['n_NL'],
            ['nl_N'],
        ];
    }
}
