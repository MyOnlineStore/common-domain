<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Exception\Tax;

use MyOnlineStore\Common\Domain\Exception\Tax\InvalidVatNumber;
use PHPUnit\Framework\TestCase;

final class InvalidVatNumberTest extends TestCase
{
    public function testWithVatNumber(): void
    {
        $exception = InvalidVatNumber::withVatNumber('foobar');

        self::assertStringContainsString('foobar', $exception->getMessage());
    }
}
