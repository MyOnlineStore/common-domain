<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Finance;

use MyOnlineStore\Common\Domain\Exception\Finance\InvalidBic;
use MyOnlineStore\Common\Domain\Value\Finance\Bic;
use PHPUnit\Framework\TestCase;

final class BicTest extends TestCase
{
    public function testFromString(): void
    {
        self::assertEquals('RABONL2U', (string) Bic::fromString('RABONL2U'));
        self::assertEquals('RABONL2U', (string) Bic::fromString('rabonl2u'));

        $this->expectException(InvalidBic::class);
        Bic::fromString('foo');
    }

    public function testEquals(): void
    {
        $bic = Bic::fromString('RABONL2U');

        self::assertTrue($bic->equals(Bic::fromString('RABONL2U')));
        self::assertTrue($bic->equals(Bic::fromString('rabonl2u')));
        self::assertFalse($bic->equals(Bic::fromString('INGBNL2A')));
    }
}
