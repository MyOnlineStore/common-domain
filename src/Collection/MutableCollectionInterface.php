<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Collection;

/**
 * @deprecated Should be moved to common-collection
 *
 * @template TKey of array-key
 * @template T
 * @extends ImmutableCollectionInterface<TKey, T>
 */
interface MutableCollectionInterface extends ImmutableCollectionInterface
{
    /**
     * @param T $element
     *
     * @return void
     */
    public function add($element);
}
