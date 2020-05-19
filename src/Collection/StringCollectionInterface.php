<?php

namespace MyOnlineStore\Common\Domain\Collection;

/**
 * @deprecated Should be moved to common-collection
 */
interface StringCollectionInterface
{
    /**
     * @return string[]
     */
    public function asStrings(): array;
}
