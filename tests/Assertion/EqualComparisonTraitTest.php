<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Assertion;

use MyOnlineStore\Common\Domain\Assertion\EqualComparisonTrait;

final class EqualComparisonTraitTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var EqualComparisonTrait
     */
    private $trait;

    protected function setUp()
    {
        $this->trait = $this->getMockForTrait(EqualComparisonTrait::class);
    }

    public function testWillReturnFalseForTypeMismatch()
    {
        self::assertFalse($this->trait->equals(new \stdClass()));
    }

    public function testWillReturnFalseForUnequalObject()
    {
        $comparison = clone $this->trait;
        $comparison->foo = null;

        self::assertFalse($this->trait->equals($comparison));
    }

    public function testWillReturnTrueForEqualObject()
    {
        $original = clone $this->trait; // Required because a mock clone differs slightly from the original object
        $comparison = clone $this->trait;

        self::assertTrue($original->equals($comparison));
    }
}
