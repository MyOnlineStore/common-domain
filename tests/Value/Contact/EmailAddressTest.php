<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Contact;

use MyOnlineStore\Common\Domain\Exception\Mail\InvalidEmailAddress;
use MyOnlineStore\Common\Domain\Value\Contact\EmailAddress;
use MyOnlineStore\Common\Domain\Value\Contact\EmailAddressValidator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class EmailAddressTest extends TestCase
{
    /** @var EmailAddressValidator&MockObject */
    private EmailAddressValidator|MockObject $validator;

    protected function setUp(): void
    {
        $this->validator = $this->createMock(EmailAddressValidator::class);
    }

    public function testConstructorAndToString(): void
    {
        $this->validator->method('__invoke')->willReturn(true);

        $emailAddress = EmailAddress::fromString('hi@mos.com', $this->validator);
        self::assertEquals('hi@mos.com', $emailAddress->toString());

        $emailAddress = EmailAddress::fromString('HÏ@Moß.com', $this->validator);
        self::assertEquals('hï@moß.com', $emailAddress->toString());
    }

    public function testConstructorDoesNotAcceptAnInvalidEmailAddress(): void
    {
        $this->validator->expects(self::once())
            ->method('__invoke')
            ->with('hi')
            ->willReturn(false);

        $this->expectException(InvalidEmailAddress::class);
        EmailAddress::fromString('hi', $this->validator);
    }

    public function testEquals(): void
    {
        $this->validator->method('__invoke')->willReturn(true);

        $emailAddress = EmailAddress::fromString('hi@mos.com', $this->validator);

        self::assertTrue($emailAddress->equals(EmailAddress::fromString('hi@mos.com', $this->validator)));
        self::assertTrue($emailAddress->equals(EmailAddress::fromString('Hi@Mos.com', $this->validator)));
        self::assertFalse($emailAddress->equals(EmailAddress::fromString('bye@mos.com', $this->validator)));
    }
}
