<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Collection;

interface StringCollectionInterface
{
    /**
     * @return string[]
     */
    public function asStrings(): array;
}
