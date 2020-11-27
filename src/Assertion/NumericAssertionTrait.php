<?php

namespace MyOnlineStore\Common\Domain\Assertion;

/**
 * @deprecated Use types instead
 *
 * @psalm-immutable
 */
trait NumericAssertionTrait
{
    /**
     * @param mixed $value
     *
     * @return bool
     */
    protected function assertIsNumeric($value)
    {
        return \is_numeric($value);
    }
}
