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
        $iban = new Iban('NL45ABNA0946659707');
        self::assertEquals('NL45ABNA0946659707', $iban->toString());
    }

    public function testConstructorDoesNotAcceptAnInvalidIban(): void
    {
        $this->expectException(InvalidIban::class);
        Iban::fromString('NLD60RABO0190431121');
    }

    public function testEquals(): void
    {
        $iban = Iban::fromString('NL45ABNA0946659707');

        self::assertTrue($iban->equals(Iban::fromString('NL45ABNA0946659707')));
        self::assertTrue($iban->equals(Iban::fromString('nl45abnA0946659707')));
        self::assertFalse($iban->equals(Iban::fromString('NL78RABO0334765924')));
    }
}
