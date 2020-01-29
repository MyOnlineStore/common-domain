<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Web;

use MyOnlineStore\Common\Domain\Value\Web\ViewPort;
use PHPUnit\Framework\TestCase;

final class ViewPortTest extends TestCase
{
    public function testAsSmall()
    {
        $viewPort = ViewPort::asSmall();

        self::assertTrue($viewPort->isSmall());
        self::assertFalse($viewPort->isMedium());
        self::assertFalse($viewPort->isLarge());

        self::assertSame('small', (string) $viewPort);
    }

    public function testAsMedium()
    {
        $viewPort = ViewPort::asMedium();

        self::assertFalse($viewPort->isSmall());
        self::assertTrue($viewPort->isMedium());
        self::assertFalse($viewPort->isLarge());

        self::assertSame('medium', (string) $viewPort);
    }

    public function testAsLarge()
    {
        $viewPort = ViewPort::asLarge();

        self::assertFalse($viewPort->isSmall());
        self::assertFalse($viewPort->isMedium());
        self::assertTrue($viewPort->isLarge());

        self::assertSame('large', (string) $viewPort);
    }

    public function testInvalid()
    {
        $this->expectException(\InvalidArgumentException::class);

        new ViewPort('xxl');
    }
}
