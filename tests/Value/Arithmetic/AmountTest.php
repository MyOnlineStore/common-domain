<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Arithmetic;

use MyOnlineStore\Common\Domain\Value\Arithmetic\Amount;
use PHPUnit\Framework\TestCase;

final class AmountTest extends TestCase
{
    public function invalidInputProvider(): \Generator
    {
        yield ['1.23'];
        yield [1.23];
        yield ['a'];
    }

    /**
     * @dataProvider invalidInputProvider
     *
     * @param mixed $input
     */
    public function testInvalidInput($input): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new Amount($input);
    }

    public function validInputProvider(): \Generator
    {
        yield [123];
        yield ['123'];
    }

    /**
     * @dataProvider validInputProvider
     *
     * @param mixed $input
     */
    public function testValidInput($input): void
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
