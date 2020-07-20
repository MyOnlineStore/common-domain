<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Arithmetic;

use MyOnlineStore\Common\Domain\Exception\InvalidArgument;
use MyOnlineStore\Common\Domain\Value\Arithmetic\Percentage;
use PHPUnit\Framework\TestCase;

final class PercentageTest extends TestCase
{
    public function testCreation()
    {
        $percentage = new Percentage(50);

        self::assertSame('50', (string) $percentage);
    }

    public function testCreationWithLessThanZeroInt()
    {
        self::expectException(InvalidArgument::class);

        new Percentage(-1);
    }

    public function testCreationWithMoreThanHunderdInt()
    {
        self::expectException(InvalidArgument::class);

        new Percentage(101);
    }

    public function testCreationWithScale()
    {
        $percentage = new Percentage(76, 4);

        self::assertSame('76.0000', (string) $percentage);
    }

    public function testIsZero()
    {
        self::assertFalse((new Percentage(98))->isZero());
        self::assertTrue((new Percentage(0))->isZero());
    }
}
