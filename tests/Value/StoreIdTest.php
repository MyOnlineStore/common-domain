<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value;

use MyOnlineStore\Common\Domain\Value\StoreId;

final class StoreIdTest extends \PHPUnit\Framework\TestCase
{
    public function testValidInput()
    {
        $this->assertEquals('123', (string) new StoreId(123));
        $this->assertEquals('1234', (string) new StoreId('1234'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Given ID "1a234" is not numeric
     */
    public function testInvalidInput()
    {
        new StoreId('1a234');
    }

    public function testEquals()
    {
        $this->assertFalse((new StoreId(1))->equals(new StoreId(2)));
        $this->assertTrue((new StoreId(1))->equals(new StoreId(1)));
    }
}
