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
            \DateTimeImmutable::createFromFormat('Y-m-d', $date, new \DateTimeZone('UTC')),
            $birthDate->getDate()
        );
        self::assertSame($date, (string) $birthDate);
    }

    public function testEquals(): void
    {
        self::assertTrue(BirthDate::fromString('2019-10-18')->equals(BirthDate::fromString('2019-10-18')));
        self::assertFalse(BirthDate::fromString('2019-10-18')->equals(BirthDate::fromString('2019-10-19')));
    }
}
