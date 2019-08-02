<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Collection;

use MyOnlineStore\Common\Domain\Collection\ImmutableCollection;
use PHPUnit\Framework\TestCase;

final class ImmutableCollectionTest extends TestCase
{
    public function testAdd(): void
    {
        $this->expectException(\LogicException::class);

        (new ImmutableCollection())->add('foo');
    }

    public function testOffsetSetWillThrowException(): void
    {
        $collection = new ImmutableCollection();

        $this->expectException(\LogicException::class);

        $collection['foo'] = 'bar';
    }
}
