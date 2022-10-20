<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Collection;

/**
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
