<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Person;

use MyOnlineStore\Common\Domain\Value\Person\BirthDate;
use PHPUnit\Framework\TestCase;

final class BirthDateTest extends TestCase
{
    public function testFromString(): void
    {
        $date = '2019-10-18';
        $birthDate = BirthDate::fromString($date);

        self::assertEquals(
            \DateTimeImmutable::createFromFormat('Y-m-d', $date),
            $birthDate->getDate(),
        );
        self::assertSame($date, (string) $birthDate);
    }

    public function testFromStringWithFormat(): void
    {
        $date = '18-10-2019';
        $birthDate = BirthDate::fromStringWithFormat($date, 'd-m-Y');

        self::assertEquals(
            \DateTimeImmutable::createFromFormat('d-m-Y', $date),
            $birthDate->getDate(),
        );
        self::assertSame('2019-10-18', (string) $birthDate);
    }

    public function testFromDateTime(): void
    {
        $birthDate = BirthDate::fromDateTime($date = new \DateTimeImmutable());
        self::assertSame($date, $birthDate->getDate());
    }

    public function testEquals(): void
    {
        self::assertTrue(BirthDate::fromStringWithFormat('2019-10-18')->equals(BirthDate::fromStringWithFormat('2019-10-18')));
        self::assertFalse(BirthDate::fromStringWithFormat('2019-10-18')->equals(BirthDate::fromStringWithFormat('2019-10-19')));
    }
}
