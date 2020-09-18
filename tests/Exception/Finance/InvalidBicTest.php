<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Exception\Finance;

use MyOnlineStore\Common\Domain\Exception\Finance\InvalidBic;
use PHPUnit\Framework\TestCase;

final class InvalidBicTest extends TestCase
{
    public function testWithBic(): void
    {
        $exception = InvalidBic::withBic('foobar');

        self::assertStringContainsString('foobar', $exception->getMessage());
    }
}
