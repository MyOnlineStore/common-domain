<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Arithmetic;

use MyOnlineStore\Common\Domain\Value\Arithmetic\Amount;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class AmountTest extends TestCase
{
    public static function invalidInputProvider(): \Generator
    {
        yield ['1.23'];
        yield [1.23];
        yield ['a'];
    }

    #[DataProvider('invalidInputProvider')]
    public function testInvalidInput(mixed $input): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new Amount($input);
    }

    public static function validInputProvider(): \Generator
    {
        yield [123];
        yield ['123'];
    }

    #[DataProvider('validInputProvider')]
    public function testValidInput(mixed $input): void
    {
        self::assertInstanceOf(Amount::class, new Amount($input));
    }

    public function testAsZero(): void
    {
        $zeroAmount = Amount::asZero();

        self::assertTrue($zeroAmount->isZero());
        self::assertSame('0', (string) $zeroAmount);
    }
}
