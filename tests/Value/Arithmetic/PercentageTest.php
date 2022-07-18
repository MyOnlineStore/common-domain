<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Arithmetic;

use MyOnlineStore\Common\Domain\Exception\InvalidArgument;
use MyOnlineStore\Common\Domain\Value\Arithmetic\Percentage;
use PHPUnit\Framework\TestCase;

final class PercentageTest extends TestCase
{
    public function testCreation(): void
    {
        $percentage = Percentage::fromString('50');

        self::assertSame('50', (string) $percentage);
    }

    public function testCreationWithDecimals(): void
    {
        $percentage = Percentage::fromString('5.55');

        self::assertSame('5.55', (string) $percentage);
    }

    public function testCreationWithLessThanZeroInt(): void
    {
        self::expectException(InvalidArgument::class);

        Percentage::fromString('-1');
    }

    public function testCreationWithNonNumericValue(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Percentage::fromString('nonNumeric');
    }

    public function testCreationWithMoreThanHunderdInt(): void
    {
        self::expectException(InvalidArgument::class);

        Percentage::fromString('101');
    }

    public function testCreationWithScale(): void
    {
        $percentage = Percentage::fromString('76', 4);

        self::assertSame('76.0000', (string) $percentage);
    }

    public function testIsZero(): void
    {
        self::assertFalse(Percentage::fromString('98')->isZero());
        self::assertTrue(Percentage::fromString('0')->isZero());
    }
}