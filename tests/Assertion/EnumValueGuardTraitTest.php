<?php

namespace MyOnlineStore\Common\Domain\Tests\Assertion;

use MyOnlineStore\Common\Domain\Assertion\EnumValueGuardTrait;

final class EnumValueGuardTraitTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var EnumValueGuardTrait
     */
    private $trait;

    protected function setUp()
    {
        $this->trait = $this->getMockForTrait(EnumValueGuardTrait::class);
    }

    public function testGuardIsValidValueNonScalarValueWillThrowInvalidArgumentException()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->trait->guardIsValidValue([]);
    }

    public function testGuardIsValidValueWithInvalidValueWillThrowInvalidArgumentException()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->trait->expects(self::once())->method('getValidValues')->willReturn(['barfoo']);

        $this->trait->guardIsValidValue('foobar');
    }

    public function testGuardIsValidValueWithVvalidValueWillReturnValue()
    {
        $this->trait->expects(self::once())->method('getValidValues')->willReturn(['foobar']);

        self::assertSame('foobar', $this->trait->guardIsValidValue('foobar'));
    }
}
