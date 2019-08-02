<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Collection;

trait StringCollectionTrait
{
    /**
     * @return string[]
     */
    public function asStrings(): array
    {
        return \array_map('strval', $this->toArray());
    }

    /**
     * @return mixed[]
     */
    abstract public function toArray(): array;
}
