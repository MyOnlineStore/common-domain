<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Collection;

/**
 * @deprecated Should be moved to common-collection
 */
interface MutableCollectionInterface extends ImmutableCollectionInterface
{
    /**
     * @param mixed $element
     */
    public function add($element);
}
