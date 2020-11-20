<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Assertion;

/**
 * assert an array contains only instances of class X
 *
 * @psalm-immutable
 */
trait ArrayContainsClassAssertionTrait
{
    /**
     * @param mixed[] $entries
     */
    public function assertArrayContainsOnlyClass(array $entries, string $className): bool
    {
        foreach ($entries as $entry) {
            if (!$entry instanceof $className) {
                return false;
            }
        }

        return true;
    }
}
