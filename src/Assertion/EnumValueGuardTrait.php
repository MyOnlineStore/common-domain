<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Assertion;

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
        $validValues = $this->getValidValues();

        if (!is_scalar($value)) {
            throw new \InvalidArgumentException(
                sprintf('given value is not a scalar value but of type %s', gettype($value))
            );
        }

        if (!in_array($value, $validValues, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Invalid %s value given: "%s" (valid values: %s)',
                    __CLASS__,
                    $value,
                    implode(', ', $validValues)
                )
            );
        }

        return $value;
    }

    /**
     * @return array
     */
    abstract protected function getValidValues();
}
