<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Exception\Contact;

use MyOnlineStore\Common\Domain\Exception\Contact\InvalidPhoneNumber;
use PHPUnit\Framework\TestCase;

final class InvalidPhoneNumberTest extends TestCase
{
    public function testWithPhoneNumber(): void
    {
        $exception = InvalidPhoneNumber::withPhoneNumber(
            'foobar',
            $previous = $this->createMock(\Throwable::class)
        );

        self::assertStringContainsString('foobar', $exception->getMessage());
        self::assertSame(0, $exception->getCode());
        self::assertSame($previous, $exception->getPrevious());
    }
}
