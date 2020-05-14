<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Finance;

use MyOnlineStore\Common\Domain\Exception\Finance\InvalidIban;
use MyOnlineStore\Common\Domain\Value\Finance\Iban;
use PHPUnit\Framework\TestCase;

final class IbanTest extends TestCase
{
    public function testConstructorAndToString(): void
    {
        $emailAddress = new Iban('NL45ABNA0946659707');
        self::assertEquals('NL45ABNA0946659707', (string) $emailAddress);
    }

    public function testConstructorDoesNotAcceptAnInvalidIban(): void
    {
        $this->expectException(InvalidIban::class);
        new Iban('NLD60RABO0190431121');
    }

    public function testEquals(): void
    {
        $emailAddress = new Iban('NL45ABNA0946659707');

        self::assertTrue($emailAddress->equals(new Iban('NL45ABNA0946659707')));
        self::assertTrue($emailAddress->equals(new Iban('nl45abnA0946659707')));
        self::assertFalse($emailAddress->equals(new Iban('NL78RABO0334765924')));
    }
}
