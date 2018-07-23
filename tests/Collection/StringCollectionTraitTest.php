<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Collection;

use MyOnlineStore\Common\Domain\Collection\StringCollectionTrait;

final class StringCollectionTraitTest extends \PHPUnit\Framework\TestCase
{
    public function testAsStringsWillReturnArrayOfStrings()
    {
        $exception = new \Exception('bar');

        /** @var StringCollectionTrait $trait */
        $trait = $this->getMockForTrait(StringCollectionTrait::class);
        $trait->expects(self::once())
            ->method('toArray')
            ->willReturn([0.00, $exception, 1337]);

        self::assertEquals(['0.00', (string) $exception, '1337'], $trait->asStrings());
    }
}
