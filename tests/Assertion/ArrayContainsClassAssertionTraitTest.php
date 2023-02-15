<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Assertion;

use MyOnlineStore\Common\Domain\Assertion\ArrayContainsClassAssertionTrait;
use MyOnlineStore\Common\Domain\Value\Locale;
use PHPUnit\Framework\TestCase;

final class ArrayContainsClassAssertionTraitTest extends TestCase
{
    public function testAssertArrayContainsOnlyClass(): void
    {
        $trait = $this->getMockForTrait(ArrayContainsClassAssertionTrait::class);

        $reflection = new \ReflectionClass($trait::class);
        $assertion = $reflection->getMethod('assertArrayContainsOnlyClass');

        self::assertTrue($assertion->invoke($trait, [new \stdClass()], \stdClass::class));
        self::assertFalse($assertion->invoke($trait, [new \stdClass(), Locale::fromString('nl_NL')], \stdClass::class));
    }
}
