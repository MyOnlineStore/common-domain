<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value;

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
     *
     * @param mixed $argument
     */
    public function testFromInvalidString($argument): void
    {
        $this->expectException('InvalidArgumentException');
        Locale::fromString($argument);
    }

    public function testFromString(): void
    {
        $locale = Locale::fromString('nl_NL');

        self::assertEquals(new RegionCode('NL'), $locale->regionCode());
        self::assertEquals(new LanguageCode('nl'), $locale->languageCode());
    }

    public function testFromStringCaseInsensitive(): void
    {
        $locale = Locale::fromString('DE_de');

        self::assertEquals(new RegionCode('DE'), $locale->regionCode());
        self::assertEquals(new LanguageCode('de'), $locale->languageCode());
    }

    public function testToString(): void
    {
        self::assertSame('nl_NL', (string) Locale::fromString('nl_NL'));
        self::assertSame('moh_CA', (string) Locale::fromString('moh_CA'));
    }

    public function testLanguageCode(): void
    {
        self::assertEquals(new LanguageCode('fr'), Locale::fromString('fr_BE')->languageCode());
        self::assertEquals(new LanguageCode('nl'), Locale::fromString('nl_BE')->languageCode());
    }

    public function testRegionCode(): void
    {
        self::assertEquals(new RegionCode('NL'), Locale::fromString('nl_NL')->regionCode());
        self::assertEquals(new RegionCode('DE'), Locale::fromString('de_DE')->regionCode());
    }

    /**
     * @return array[]
     */
    public function invalidArgumentProvider(): array
    {
        return [
            [123],
            ['ca_MOH'],
            ['nl'],
            ['n_NL'],
            ['nl_N'],
        ];
    }
}
