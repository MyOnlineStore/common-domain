<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Arithmetic;

use Litipk\BigNumbers\Decimal;
use Litipk\BigNumbers\Errors\BigNumbersError;

class Number
{
    /** @var Decimal */
    protected $value;

    /**
     * @param mixed $value
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($value, int $scale = null)
    {
        $this->assignValue($value, $scale);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->value;
    }

    /**
     * @return static
     */
    public function add(Number $operand, int $scale = null)
    {
        $this->assertOperand($operand);

        return $this->changeValue($this->value->add($operand->value, $scale), $scale);
    }

    /**
     * @return static
     *
     * @throws \InvalidArgumentException
     */
    public function changeValue($value, int $scale = null)
    {
        $newMetric = clone $this;
        $newMetric->assignValue($value, $scale);

        return $newMetric;
    }

    /**
     * @return static
     */
    public function divideBy(Number $operand, int $scale = null)
    {
        $this->assertOperand($operand);

        return $this->changeValue($this->value->div($operand->value, $scale), $scale);
    }

    /**
     * @return bool
     */
    public function equals(Number $operand, int $scale = null)
    {
        $this->assertOperand($operand);

        return $this->value->equals($operand->value, $scale);
    }

    public function isGreaterThan(Number $operand, int $scale = null): bool
    {
        return 1 === $this->value->comp($operand->value, $scale);
    }

    public function isLessThan(Number $operand, int $scale = null): bool
    {
        return -1 === $this->value->comp($operand->value, $scale);
    }

    /**
     * @return bool
     */
    public function isZero()
    {
        return $this->value->isZero();
    }

    /**
     * @return static
     */
    public function multiplyBy(Number $operand, int $scale = null)
    {
        $this->assertOperand($operand);

        return $this->changeValue($this->value->mul($operand->value, $scale), $scale);
    }

    /**
     * @return static
     */
    public function powerTo(Number $operand, int $scale = null)
    {
        return $this->changeValue($this->value->pow($operand->value, $scale));
    }

    /**
     * @return static
     */
    public function subtract(Number $operand, int $scale = null)
    {
        $this->assertOperand($operand);

        return $this->changeValue($this->value->sub($operand->value, $scale), $scale);
    }

    /**
     * @return static
     */
    public function toScale(int $scale)
    {
        return $this->changeValue($this->value->div(Decimal::create(10)->pow(Decimal::create($scale)), $scale));
    }

    protected function assertOperand(Number $operand): void
    {
        // scope to perform assertions to guard against inproper operands
    }

    /**
     * @param mixed $value
     *
     * @throws \InvalidArgumentException
     */
    private function assignValue($value, int $scale = null): void
    {
        if ($value instanceof self) {
            $value = $value->value;
        }

        try {
            $this->value = Decimal::create($value, $scale);
        } catch (BigNumbersError $exception) {
            throw new \InvalidArgumentException($exception->getMessage(), 0, $exception);
        }
    }
}
