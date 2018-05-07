<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Collection;

use MyOnlineStore\Common\Domain\Collection\ImmutableCollection;

final class ImmutableCollectionTest extends \PHPUnit\Framework\TestCase
{
    public function testAdd()
    {
        $this->expectException(\LogicException::class);

        (new ImmutableCollection())->add('foo');
    }

    public function testOffsetSetWillThrowException()
    {
        $collection = new ImmutableCollection();

        $this->expectException(\LogicException::class);

        $collection['foo'] = 'bar';
    }
}
