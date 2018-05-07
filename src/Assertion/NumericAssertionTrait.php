<?php

namespace MyOnlineStore\Common\Domain\Assertion;

trait NumericAssertionTrait
{
    /**
     * @param mixed $value
     *
     * @return bool
     */
    protected function assertIsNumeric($value)
    {
        return is_numeric($value);
    }
}
