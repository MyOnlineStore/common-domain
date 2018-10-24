<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Collection;

use MyOnlineStore\Common\Domain\Collection\StoreIds;
use MyOnlineStore\Common\Domain\Value\StoreId;
use PHPUnit\Framework\TestCase;

final class StoreIdsTest extends TestCase
{
    public function testConstructorWillEnsureValueObjects()
    {
        self::assertEquals(
            new StoreIds([new StoreId(123), new StoreId(456), new StoreId(789)]),
            new StoreIds([new StoreId(123), '456', 789])
        );
    }

    public function testContainsWillCompareBasedOnEqualityInsteadOfIdentity()
    {
        $storeId = new StoreId(123);
        $storeIds = new StoreIds([$storeId]);

        self::assertTrue($storeIds->contains($storeId));
        self::assertFalse($storeIds->contains(new StoreId(456)));
    }
}
