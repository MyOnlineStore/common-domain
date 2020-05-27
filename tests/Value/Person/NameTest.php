<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Person;

use MyOnlineStore\Common\Domain\Value\Person\Name;
use MyOnlineStore\Common\Domain\Value\Person\Name\FirstName;
use MyOnlineStore\Common\Domain\Value\Person\Name\LastName;
use PHPUnit\Framework\TestCase;

final class NameTest extends TestCase
{
    public function testName(): void
    {
        $name = new Name(
            $firstname = FirstName::fromString('foo'),
            $lastname = LastName::fromString('bar')
        );

        self::assertSame($firstname, $name->getFirstName());
        self::assertSame($lastname, $name->getLastName());

        self::assertSame('foo bar', (string) $name);
    }
}
