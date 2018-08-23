<?php

namespace MyOnlineStore\Common\Domain\Tests\Value\Arithmetic;

use MyOnlineStore\Common\Domain\Value\Arithmetic\Amount;

final class AmountTest extends \PHPUnit\Framework\TestCase
{
    public function testInvalidConstruction()
    {
        $this->expectException(\InvalidArgumentException::class);

        new Amount('1.23');
    }
}
