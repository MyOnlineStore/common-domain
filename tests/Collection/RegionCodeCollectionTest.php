<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Collection;

use MyOnlineStore\Common\Domain\Collection\RegionCodeCollection;
use MyOnlineStore\Common\Domain\Value\RegionCode;

final class RegionCodeCollectionTest extends \PHPUnit\Framework\TestCase
{
    public function testContainsShouldReturnIfTheGivenRegionCodeIsPresentInCollection()
    {
        $regionCodes = new RegionCodeCollection([new RegionCode('NL'), new RegionCode('DE')]);

        self::assertTrue($regionCodes->contains(new RegionCode('NL')));
        self::assertFalse($regionCodes->contains(new RegionCode('GB')));
    }

    public function testFromCountryNamesWillReturnNewRegionCodeCollection()
    {
        self::assertEquals(
            new RegionCodeCollection(
                [
                    new RegionCode('NL'),
                    new RegionCode('BE'),
                    new RegionCode('DE'),
                ]
            ),
            RegionCodeCollection::fromStrings(['NL', 'BE', 'DE'])
        );
    }

    public function testUniqueWillReturnCollectionWithUniqueCodesOnly()
    {
        $collection = new RegionCodeCollection(
            [
                new RegionCode('NL'),
                new RegionCode('BE'),
                new RegionCode('DE'),
                new RegionCode('NL'),
                new RegionCode('DE'),
                'foo',
            ]
        );

        self::assertEquals(
            new RegionCodeCollection(
                [
                    new RegionCode('NL'),
                    new RegionCode('BE'),
                    new RegionCode('DE'),
                ]
            ),
            $collection->unique()
        );
    }
}
