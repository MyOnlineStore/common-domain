<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Assertion;

use MyOnlineStore\Common\Domain\Assertion\ArrayContainsClassAssertionTrait;
use MyOnlineStore\Common\Domain\Value\Locale;

final class ArrayContainsClassAssertionTraitTest extends \PHPUnit\Framework\TestCase
{
    public function testAssertArrayContainsOnlyClass()
    {
        $trait = $this->getMockForTrait(ArrayContainsClassAssertionTrait::class);

        $reflection = new \ReflectionClass(\get_class($trait));
        $assertion = $reflection->getMethod('assertArrayContainsOnlyClass');
        $assertion->setAccessible(true);

        self::assertTrue($assertion->invoke($trait, [new \stdClass()], \stdClass::class));
        self::assertFalse($assertion->invoke($trait, [new \stdClass(), Locale::fromString('nl_NL')], \stdClass::class));
    }
}
