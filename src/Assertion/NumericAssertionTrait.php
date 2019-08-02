<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Assertion;

trait NumericAssertionTrait
{
    /**
     * @param mixed $value
     */
    protected function assertIsNumeric($value): bool
    {
        return \is_numeric($value);
    }
}
