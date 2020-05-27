<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Collection;

use MyOnlineStore\Common\Domain\Collection\StringCollectionTrait;
use PHPUnit\Framework\TestCase;

final class StringCollectionTraitTest extends TestCase
{
    public function testAsStringsWillReturnArrayOfStrings(): void
    {
        $exception = new \Exception('bar');

        $trait = $this->getMockForTrait(StringCollectionTrait::class);
        $trait->expects(self::once())
            ->method('toArray')
            ->willReturn([1.23, $exception, 1337]);

        self::assertEquals(['1.23', (string) $exception, '1337'], $trait->asStrings());
    }
}
