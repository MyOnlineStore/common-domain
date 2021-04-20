<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Tax;

use MyOnlineStore\Common\Domain\Exception\Tax\InvalidVatNumber;
use MyOnlineStore\Common\Domain\Value\Tax\VatNumber;
use MyOnlineStore\Common\Domain\Value\Tax\VatNumberValidator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class VatNumberTest extends TestCase
{
    /** @var VatNumberValidator&MockObject */
    private VatNumberValidator|MockObject $validator;

    protected function setUp(): void
    {
        $this->validator = $this->createMock(VatNumberValidator::class);
    }

    public function testAccessors(): void
    {
        $this->validator->method('__invoke')->willReturn(true);

        $vatNumber = VatNumber::fromString('NL1234', $this->validator);
        self::assertSame('NL1234', $vatNumber->toString());

        $vatNumber = VatNumber::fromString('nl1234', $this->validator);
        self::assertSame('NL1234', $vatNumber->toString());
    }

    public function testValidation(): void
    {
        $this->validator->expects(self::exactly(2))
            ->method('__invoke')
            ->withConsecutive(
                ['NL1234'],
                ['DE5678']
            )
            ->willReturnOnConsecutiveCalls(
                true,
                false
            );

        self::assertSame('NL1234', VatNumber::fromString('NL1234', $this->validator)->toString());

        $this->expectException(InvalidVatNumber::class);

        VatNumber::fromString('DE5678', $this->validator);
    }

    public function testEquals(): void
    {
        $this->validator->method('__invoke')->willReturn(true);

        $vatNumber = VatNumber::fromString('NL1234', $this->validator);

        self::assertTrue($vatNumber->equals(VatNumber::fromString('NL1234', $this->validator)));
        self::assertTrue($vatNumber->equals(VatNumber::fromString('nl1234', $this->validator)));
        self::assertFalse($vatNumber->equals(VatNumber::fromString('DE5678', $this->validator)));
    }
}
