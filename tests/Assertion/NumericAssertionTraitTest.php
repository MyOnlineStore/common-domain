<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Assertion;

use MyOnlineStore\Common\Domain\Assertion\NumericAssertionTrait;
use PHPUnit\Framework\TestCase;

final class NumericAssertionTraitTest extends TestCase
{
    public function testAssertIsNumeric()
    {
        $trait = $this->getMockForTrait(NumericAssertionTrait::class);

        $reflection = new \ReflectionClass(\get_class($trait));
        $assertion = $reflection->getMethod('assertIsNumeric');
        $assertion->setAccessible(true);

        self::assertFalse($assertion->invoke($trait, 'foo'));
        self::assertTrue($assertion->invoke($trait, 10));
        self::assertTrue($assertion->invoke($trait, '00101'));
        self::assertTrue($assertion->invoke($trait, 1e4));
    }
}
