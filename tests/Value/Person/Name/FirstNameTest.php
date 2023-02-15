<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Person\Name;

use MyOnlineStore\Common\Domain\Exception\InvalidArgument;
use MyOnlineStore\Common\Domain\Value\Person\Name\FirstName;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class FirstNameTest extends TestCase
{
    public function testNotEmpty(): void
    {
        self::assertSame('foo', (string) FirstName::fromString('foo'));
    }

    public static function emptyDataProvider(): \Generator
    {
        yield [''];
        yield [' '];
        yield ['  '];
        yield ["\t"];
        yield ["\t "];
    }

    #[DataProvider('emptyDataProvider')]
    public function testEmpty(string $empty): void
    {
        $this->expectException(InvalidArgument::class);
        FirstName::fromString($empty);
    }

    public function testEquals(): void
    {
        $firstName = FirstName::fromString('foo');

        self::assertTrue($firstName->equals(FirstName::fromString('foo')));
        self::assertTrue($firstName->equals(FirstName::fromString('FoO')));
        self::assertFalse($firstName->equals(FirstName::fromString('bar')));
    }
}
