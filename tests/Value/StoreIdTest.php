<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value;

use MyOnlineStore\Common\Domain\Value\StoreId;
use PHPUnit\Framework\TestCase;

final class StoreIdTest extends TestCase
{
    public function testValidInput(): void
    {
        $this->assertEquals('123', (string) new StoreId(123));
        $this->assertEquals('1234', (string) new StoreId(1234));
    }

    public function testEquals(): void
    {
        $this->assertFalse((new StoreId(1))->equals(new StoreId(2)));
        $this->assertTrue((new StoreId(1))->equals(new StoreId(1)));
    }
}
