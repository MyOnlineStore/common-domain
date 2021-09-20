<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Exception\Color;

use MyOnlineStore\Common\Domain\Exception\Color\InvalidHexColor;
use PHPUnit\Framework\TestCase;

final class InvalidHexColorTest extends TestCase
{
    public function testWithHexColor(): void
    {
        $exception = InvalidHexColor::withHexColor(
            'foobar',
            $previous = $this->createMock(\Throwable::class)
        );

        self::assertStringContainsString('foobar', $exception->getMessage());
        self::assertSame(0, $exception->getCode());
        self::assertSame($previous, $exception->getPrevious());
    }
}
