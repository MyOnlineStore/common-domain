<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Person\Name;

use MyOnlineStore\Common\Domain\Exception\InvalidArgument;
use MyOnlineStore\Common\Domain\Value\Person\Name\LastName;
use PHPUnit\Framework\TestCase;

final class LastNameTest extends TestCase
{
    public function testNotEmpty(): void
    {
        self::assertSame('foo', (string) LastName::fromString('foo'));
    }

    public function emptyDataProvider(): \Generator
    {
        yield [''];
        yield [' '];
        yield ['  '];
        yield ["\t"];
        yield ["\t "];
    }

    /**
     * @dataProvider emptyDataProvider
     */
    public function testEmpty(string $empty): void
    {
        $this->expectException(InvalidArgument::class);
        LastName::fromString($empty);
    }

    public function testEquals(): void
    {
        $lastName = LastName::fromString('foo');

        self::assertTrue($lastName->equals(LastName::fromString('foo')));
        self::assertFalse($lastName->equals(LastName::fromString('bar')));
    }
}
