<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Location\Address;

use MyOnlineStore\Common\Domain\Exception\InvalidArgument;
use MyOnlineStore\Common\Domain\Value\Location\Address\StreetSuffix;
use PHPUnit\Framework\TestCase;

final class StreetSuffixTest extends TestCase
{
    public function testNotEmpty(): void
    {
        self::assertSame('foo', (string) StreetSuffix::fromString('foo'));
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
        StreetSuffix::fromString($empty);
    }
}