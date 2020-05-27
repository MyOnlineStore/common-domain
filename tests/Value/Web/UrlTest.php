<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Web;

use League\Uri\Uri;
use MyOnlineStore\Common\Domain\Value\Web\Url;
use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{
    /**
     * @return string[][]
     */
    public function validUrlDataProvider(): array
    {
        return [
            ['', '/'],
            ['//host.com/foo', '//host.com/foo'],
            ['https://api.host.com:8080/api-route?token=foo#bar', 'https://api.host.com:8080/api-route?token=foo#bar'],
        ];
    }

    /**
     * @dataProvider validUrlDataProvider
     */
    public function testFromStringWillParseStringCorrectly(string $input): void
    {
        self::assertEquals((string) Uri::createFromString($input), (string) Url::fromString($input));
    }

    /**
     * @return string[][]
     */
    public function invalidUrlDataProvider(): array
    {
        return [['http://'], ['htp:/www.myofflinestore.com'], ["\x00foobar\x01"]];
    }

    /**
     * @dataProvider invalidUrlDataProvider
     */
    public function testFromStringWillThrowExceptionForMalformedUrls(string $input): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Url::fromString($input);
    }

    public function testEqualsWillReturnTrueIfObjectMatches(): void
    {
        $otherUrl = Url::createFromString('https://api.host.com/api-route')
            ->withQuery('token=foo')
            ->withFragment('bar')
            ->withPort(8080);

        self::assertTrue(Url::createFromString('https://api.host.com:8080/api-route?token=foo#bar')->equals($otherUrl));
    }

    /**
     * @dataProvider invalidEqualUrlProvider
     */
    public function testEqualsWillReturnFalseIfObjectDoesNotMatch(Url $otherUrl): void
    {
        self::assertFalse(
            Url::createFromString('https://api.host.com:8080/api-route?token=foo#bar')->equals($otherUrl)
        );
    }

    /**
     * @return Url[][]
     */
    public function invalidEqualUrlProvider(): array
    {
        return [
            [Url::createFromString('https://api.host.com')],
            [Url::createFromString('https://api.host.com:8080')],
            [Url::createFromString('https://api.host.com:8080/api-route')],
            [Url::createFromString('https://api.host.com:8080/api-route?token=foo')],
        ];
    }
}
