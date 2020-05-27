<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Web;

use MyOnlineStore\Common\Domain\Value\Web\UrlPathType;
use PHPUnit\Framework\TestCase;

final class UrlPathTypeTest extends TestCase
{
    public function testToInt(): void
    {
        self::assertEquals(UrlPathType::ABSOLUTE_PATH, UrlPathType::asAbsolutePath()->toInt());
        self::assertEquals(UrlPathType::ABSOLUTE_URL, UrlPathType::asAbsoluteUrl()->toInt());
        self::assertEquals(UrlPathType::NETWORK_PATH, UrlPathType::asNetworkPath()->toInt());
        self::assertEquals(UrlPathType::RELATIVE_PATH, UrlPathType::asRelativePath()->toInt());
    }
}
