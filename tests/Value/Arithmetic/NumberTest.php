<?php

namespace MyOnlineStore\Tests\Domain\Value\Arithmetic;

use MyOnlineStore\Common\Domain\Value\Arithmetic\Number;
use PHPUnit\Framework\TestCase;

class NumberTest extends TestCase
{
    public function testAdd()
    {
        self::assertEquals(new Number(666), (new Number(123))->add(new Number(543)));
        self::assertTrue((new Number(666.0))->equals((new Number(123))->add(new Number(543))));
        self::assertEquals(new Number(666.666), (new Number(123.123))->add(new Number(543.543)));
        self::assertEquals(new Number(666.666), (new Number(123.666))->add(new Number(543)));
        self::assertEquals(new Number(666.666), (new Number(123))->add(new Number(543.666)));
        self::assertNotEquals(new Number(0), (new Number(666.6))->add(new Number(-666.6))); // scale mismatch
        self::assertEquals(new Number(0.0), (new Number(666.6))->add(new Number(-666.6)));
        self::assertNotEquals(new Number(666.6666), (new Number(123))->add(new Number(543.666)));
        self::assertNotEquals(new Number(666.7), (new Number(123.123))->add(new Number(543.543), 1)); // scale mismatch
        self::assertEquals(new Number(666.7, 1), (new Number(123.123))->add(new Number(543.543), 1));
    }

    public function testAssertOperand()
    {
        $operand = new Number(543);

        $numberMock = $this->getMockBuilder(Number::class)
            ->setConstructorArgs([123])
            ->setMethods(['assertOperand'])
            ->getMockForAbstractClass();

        $numberMock->expects(self::exactly(5))->method('assertOperand')->with($operand);

        // Make sure the assertion is performed during all operations:
        $numberMock->add($operand);
        $numberMock->divideBy($operand);
        $numberMock->equals($operand);
        $numberMock->multiplyBy($operand);
        $numberMock->subtract($operand);
    }

    public function testAssignValuePreservesClass()
    {
        $subclassedNumber = $this->createSubclassedNumber(123);
        $newSubclassedNumber = $subclassedNumber->add(new Number(543));

        self::assertNotEquals(\get_class($subclassedNumber), Number::class);
        self::assertInstanceOf(\get_class($subclassedNumber), $newSubclassedNumber);
        self::assertEquals($this->createSubclassedNumber(666), $newSubclassedNumber);

        self::assertEquals(new Number(666), (new Number(543))->add($subclassedNumber));
    }

    public function testChangeValue()
    {
        self::assertEquals(new Number(666), (new Number(123))->changeValue(666));
        self::assertEquals(new Number(666), (new Number(123.4))->changeValue(666));
        self::assertNotEquals(new Number(666), (new Number(123.4))->changeValue(666, 1));
        self::assertEquals(new Number(666, 1), (new Number(123.4))->changeValue(666, 1));
        self::assertEquals(new Number(666), (new Number(123.4, 2))->changeValue(666)); // old scale is ignored
    }

    public function testDivideBy()
    {
        self::assertEquals(new Number(111), (new Number(666))->divideBy(new Number(6)));
        self::assertEquals(new Number(111.1), (new Number(666.6))->divideBy(new Number(6)));
        self::assertEquals(new Number(1.111), (new Number(666.6))->divideBy(new Number('6.0E2')));
    }

    public function testEquals()
    {
        self::assertTrue((new Number(666))->equals(new Number(666)));
        self::assertTrue((new Number(666))->equals(new Number(666.0))); // equals does normalizes scale difference
        self::assertTrue((new Number(666))->equals(new Number('666')));
        self::assertTrue((new Number(666))->equals(new Number('666.0')));
        self::assertFalse((new Number(666))->equals(new Number(66.6)));
    }

    public function testIsGreaterThan()
    {
        self::assertTrue((new Number(666))->isGreaterThan(new Number(665)));
        self::assertTrue((new Number(6.66))->isGreaterThan(new Number(6.65)));
        self::assertTrue((new Number(-6.65))->isGreaterThan(new Number(-6.66)));
        self::assertFalse((new Number(665))->isGreaterThan(new Number(666)));
    }

    public function testIsLessThan()
    {
        self::assertTrue((new Number(665))->isLessThan(new Number(666)));
        self::assertTrue((new Number(6.65))->isLessThan(new Number(6.66)));
        self::assertTrue((new Number(-6.66))->isLessThan(new Number(-6.65)));
        self::assertFalse((new Number(666))->isLessThan(new Number(665)));
    }

    public function testIsZero()
    {
        self::assertTrue((new Number(0))->isZero());
        self::assertTrue((new Number(0.0))->isZero());
        self::assertTrue((new Number('0'))->isZero());
        self::assertTrue((new Number('0.0'))->isZero());
        self::assertFalse((new Number(0.1))->isZero());
        self::assertFalse((new Number(-0.1))->isZero());
    }

    public function testMultiplyBy()
    {
        self::assertEquals(new Number(666), (new Number(111))->multiplyBy(new Number(6)));

        // do not give a scale to the operation nor the expected value (results in scale difference)
        self::assertNotEquals(new Number(666.66), (new Number(111.11))->multiplyBy(new Number(6)));

        // set the operation scale to the same scale as the implict scale of the expected value
        self::assertEquals(new Number(666.66), (new Number(111.11))->multiplyBy(new Number(6), 16));

        // set the expected value scale to the same scale as the implicit scale of the operation result
        self::assertEquals(new Number(666.66, 2), (new Number(111.11))->multiplyBy(new Number(6)));

        // align the scale of the operation result and expected value
        self::assertEquals(new Number(666.66, 3), (new Number(111.11))->multiplyBy(new Number(6), 3));
    }

    public function testPowerTo()
    {
        self::assertEquals(new Number(256), (new Number(2))->powerTo(new Number(8)));
    }

    public function testSubtract()
    {
        self::assertEquals(new Number(666), (new Number(1000))->subtract(new Number(334)));
        self::assertEquals(new Number(666.7), (new Number(1000))->subtract(new Number(333.3)));
        self::assertEquals(new Number(666.7), (new Number('1.0E3'))->subtract(new Number(333.3)));
    }

    public function testToScale()
    {
        self::assertEquals(new Number('1.23'), (new Number(123))->toScale(2));
        self::assertEquals(new Number(1.23, 2), (new Number(123))->toScale(2));
        self::assertNotEquals(new Number(1.23), (new Number(123))->toScale(2)); // implicit expectation scale
    }

    /**
     * @param mixed $value
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|Number
     */
    private function createSubclassedNumber($value)
    {
        return $this->getMockBuilder(Number::class)->setConstructorArgs([$value])->getMockForAbstractClass();
    }
}
