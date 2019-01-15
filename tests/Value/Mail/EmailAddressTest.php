<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Mail;

use MyOnlineStore\Common\Domain\Exception\Mail\InvalidEmailAddress;
use MyOnlineStore\Common\Domain\Value\Mail\EmailAddress;
use PHPUnit\Framework\TestCase;

final class EmailAddressTest extends TestCase
{
    public function testConstructorAndToString()
    {
        $emailAddress = new EmailAddress('hi@mos.com');
        self::assertEquals('hi@mos.com', (string) $emailAddress);
    }

    public function testConstructorDoesNotAcceptAnInvalidEmailAddress()
    {
        $this->expectException(InvalidEmailAddress::class);
        new EmailAddress('hi');
    }

    public function testEquals()
    {
        $emailAddress = new EmailAddress('hi@mos.com');

        self::assertTrue($emailAddress->equals(new EmailAddress('hi@mos.com')));
        self::assertFalse($emailAddress->equals(new EmailAddress('bye@mos.com')));
    }
}
