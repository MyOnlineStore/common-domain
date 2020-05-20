<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Person;

use MyOnlineStore\Common\Domain\Exception\Person\InvalidGender;
use MyOnlineStore\Common\Domain\Value\Person\Gender;
use PHPUnit\Framework\TestCase;

final class GenderTest extends TestCase
{
    public function testMale(): void
    {
        $gender = Gender::asMale();

        self::assertSame('M', (string) $gender);
        self::assertTrue($gender->isMale());
        self::assertFalse($gender->isFemale());
        self::assertTrue($gender->equals(Gender::fromString('M')));
        self::assertFalse($gender->equals(Gender::asFemale()));
    }

    public function testFemale(): void
    {
        $gender = Gender::asFemale();

        self::assertSame('F', (string) $gender);
        self::assertTrue($gender->isFemale());
        self::assertFalse($gender->isMale());
        self::assertTrue($gender->equals(Gender::fromString('F')));
        self::assertFalse($gender->equals(Gender::asMale()));
    }

    public function testInvalid(): void
    {
        $this->expectException(InvalidGender::class);
        Gender::fromString('foo');
    }
}
