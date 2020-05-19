<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Location\Address;

use MyOnlineStore\Common\Domain\Exception\InvalidArgument;
use MyOnlineStore\Common\Domain\Value\Location\Address\ZipCode;
use PHPUnit\Framework\TestCase;

final class ZipCodeTest extends TestCase
{
    public function testAsNotAvailableWillReturnCorrectVersion(): void
    {
        $zipcode = ZipCode::asNotAvailable();

        self::assertSame('N/A', (string) $zipcode);
    }

    public function testEqualsWillReturnCaseAndSpaceInsensitiveEquality(): void
    {
        $zipcode = ZipCode::fromString('1111AA');

        self::assertFalse($zipcode->equals(ZipCode::fromString('1111AB')));
        self::assertTrue($zipcode->equals(ZipCode::fromString('1111 aa')));
    }

    public function testThrowsExceptionIfEmpty(): void
    {
        $this->expectException(InvalidArgument::class);
        ZipCode::fromString('');
    }

    public function testUppercaseTransformation(): void
    {
        $this->assertSame('5000 AA', (string) ZipCode::fromString('5000 aa'));
        $this->assertSame('5000BB', (string) ZipCode::fromString('5000bb'));
    }
}
