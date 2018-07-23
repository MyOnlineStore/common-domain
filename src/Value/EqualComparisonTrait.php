<?php

namespace MyOnlineStore\Common\Domain\Value;

trait EqualComparisonTrait
{
    /**
     * @param object $object
     *
     * @return bool
     */
    public function equals($object)
    {
        if (!$object instanceof $this) {
            return false;
        }

        return $this == $object;
    }
}
