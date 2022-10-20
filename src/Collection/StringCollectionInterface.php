<?php

namespace MyOnlineStore\Common\Domain\Collection;

interface StringCollectionInterface
{
    /** @return string[] */
    public function asStrings(): array;
}
