<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Assertion;

use MyOnlineStore\Common\Domain\Assertion\EnumValueGuardTrait;
use PHPUnit\Framework\TestCase;

final class EnumValueGuardTraitTest extends TestCase
{
    /** @var EnumValueGuardTrait */
    private $trait;

    protected function setUp(): void
    {
        $this->trait = $this->getMockForTrait(EnumValueGuardTrait::class);
    }

    public function testGuardIsValidValueNonScalarValueWillThrowInvalidArgumentException(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->trait->guardIsValidValue([]);
    }

    public function testGuardIsValidValueWithInvalidValueWillThrowInvalidArgumentException(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->trait->expects(self::once())->method('getValidValues')->willReturn(['barfoo']);

        $this->trait->guardIsValidValue('foobar');
    }

    public function testGuardIsValidValueWithVvalidValueWillReturnValue(): void
    {
        $this->trait->expects(self::once())->method('getValidValues')->willReturn(['foobar']);

        self::assertSame('foobar', $this->trait->guardIsValidValue('foobar'));
    }
}
