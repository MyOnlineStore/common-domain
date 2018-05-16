<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Assertion;

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
