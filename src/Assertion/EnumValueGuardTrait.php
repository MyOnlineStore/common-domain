<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Assertion;

/**
 * @psalm-immutable
 */
trait EnumValueGuardTrait
{
    /**
     * @param mixed $value
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public function guardIsValidValue($value)
    {
        if (!\is_scalar($value)) {
            throw new \InvalidArgumentException(
                \sprintf('given value is not a scalar value but of type %s', \gettype($value))
            );
        }

        $validValues = $this->getValidValues();

        if (!\in_array($value, $validValues, true)) {
            throw new \InvalidArgumentException(
                \sprintf(
                    'Invalid %s value given: "%s" (valid values: %s)',
                    self::class,
                    $value,
                    \implode(', ', $validValues)
                )
            );
        }

        return $value;
    }

    /**
     * @return mixed[]
     *
     * @psalm-pure
     */
    abstract protected function getValidValues();
}
