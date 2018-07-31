<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Collection;

use MyOnlineStore\Common\Domain\Collection\LocaleCollection;
use MyOnlineStore\Common\Domain\Collection\RegionCodeCollection;
use MyOnlineStore\Common\Domain\Value\CurrencyIso;
use MyOnlineStore\Common\Domain\Value\Locale;
use MyOnlineStore\Common\Domain\Value\RegionCode;

final class LocaleCollectionTest extends \PHPUnit\Framework\TestCase
{
    public function testAsRegionCodesWillReturnRegionCodeCollection()
    {
        $collection = new LocaleCollection(
            [
                Locale::fromString('nl_BE'),
                Locale::fromString('fr_BE'),
                Locale::fromString('de_DE'),
            ]
        );

        self::assertEquals(
            new RegionCodeCollection([new RegionCode('BE'), new RegionCode('DE')]),
            $collection->asRegionCodes()
        );
    }

    public function testAsString()
    {
        $collection = new LocaleCollection(
            [
                Locale::fromString('nl_NL'),
                Locale::fromString('nl_BE'),
                Locale::fromString('de_DE'),
            ]
        );

        self::assertEquals(['nl_NL', 'nl_BE', 'de_DE'], $collection->asStrings());
    }

    public function testContains()
    {
        $collection = new LocaleCollection([Locale::fromString('nl_NL'), Locale::fromString('de_DE')]);
        self::assertTrue($collection->contains(Locale::fromString('de_DE')));
        self::assertFalse($collection->contains(Locale::fromString('nl_BE')));
    }

    public function testFromStringsWillConvertAndFilterInput()
    {
        $collection = LocaleCollection::fromStrings(['nl', 'nl_BE', 'fr_BE', 'FR']);

        self::assertEquals(
            new LocaleCollection(
                [1 => Locale::fromString('nl_BE'), 2 => Locale::fromString('fr_BE')]
            ),
            $collection
        );
    }

    public function testGroupByCurrencyFormat()
    {
        $collection = new LocaleCollection(
            [
                Locale::fromString('nl_NL'),
                Locale::fromString('nl_BE'),
                Locale::fromString('de_DE'),
            ]
        );

        self::assertEquals(
            [
                '€ 123.456.789,12' => new LocaleCollection([Locale::fromString('nl_NL')]),
                '123.456.789,12 €' => new LocaleCollection([Locale::fromString('nl_BE'), Locale::fromString('de_DE')]),
            ],
            $collection->groupByCurrencyFormat(new CurrencyIso('EUR'), 123456789.1234)
        );
    }

    public function testUnique()
    {
        $locales = LocaleCollection::fromStrings(['nl_NL', 'de_DE', 'nl_NL']);
        self::assertCount(3, $locales);
        self::assertEquals(LocaleCollection::fromStrings(['nl_NL', 'de_DE']), $locales->unique());
    }
}
