<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Web;

use MyOnlineStore\Common\Domain\Value\Web\UrlPath;
use PHPUnit\Framework\TestCase;

class UrlPathTest extends TestCase
{
    public function testConstructWillIgnoreLeadingSlash()
    {
        self::assertEquals(new UrlPath('/foo/bar'), new UrlPath('foo/bar'));
    }

    public function testIsEmptyWillReturnWhetherPathIsEmpty()
    {
        $emptyPath = new UrlPath('/');
        $nonEmptyPath = new UrlPath('/foo/bar');

        self::assertTrue($emptyPath->isEmpty());
        self::assertFalse($nonEmptyPath->isEmpty());
    }

    public function testToStringWillPrependLeadingSlash()
    {
        self::assertEquals('/foo/bar', (string) new UrlPath('foo/bar'));
    }
}
