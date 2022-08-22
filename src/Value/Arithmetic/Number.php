<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Arithmetic;

use Litipk\BigNumbers\Decimal;
use Litipk\BigNumbers\Errors\BigNumbersError;

/**
 * @psalm-immutable
 */
class Number
{
    /** @var Decimal */
    protected $value;

    /**
     * @param float|int|string|self $value
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($value, ?int $scale = null)
    {
        $this->assignValue($value, $scale);
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    /**
     * @return static
     */
    public function add(Number $operand, ?int $scale = null)
    {
        $this->assertOperand($operand);

        /** @psalm-suppress ImpureMethodCall */
        return $this->changeValue($this->value->add($operand->value, $scale), $scale);
    }

    /**
     * @param mixed $value
     *
     * @return static
     *
     * @throws \InvalidArgumentException
     */
    public function changeValue($value, ?int $scale = null)
    {
        $newMetric = clone $this;
        $newMetric->assignValue($value, $scale);

        return $newMetric;
    }

    /**
     * @return static
     */
    public function divideBy(Number $operand, ?int $scale = null)
    {
        $this->assertOperand($operand);

        /** @psalm-suppress ImpureMethodCall */
        return $this->changeValue($this->value->div($operand->value, $scale), $scale);
    }

    public function equals(Number $operand, ?int $scale = null): bool
    {
        $this->assertOperand($operand);

        /** @psalm-suppress ImpureMethodCall */
        return $this->value->equals($operand->value, $scale);
    }

    public function isGreaterThan(Number $operand, ?int $scale = null): bool
    {
        /** @psalm-suppress ImpureMethodCall */
        return 1 === $this->value->comp($operand->value, $scale);
    }

    public function isLessThan(Number $operand, ?int $scale = null): bool
    {
        /** @psalm-suppress ImpureMethodCall */
        return -1 === $this->value->comp($operand->value, $scale);
    }

    public function isZero(): bool
    {
        /** @psalm-suppress ImpureMethodCall */
        return $this->value->isZero();
    }

    /**
     * @return static
     */
    public function multiplyBy(Number $operand, ?int $scale = null)
    {
        $this->assertOperand($operand);

        /** @psalm-suppress ImpureMethodCall */
        return $this->changeValue($this->value->mul($operand->value, $scale), $scale);
    }

    /**
     * @return static
     */
    public function powerTo(Number $operand, ?int $scale = null)
    {
        /** @psalm-suppress ImpureMethodCall */
        return $this->changeValue($this->value->pow($operand->value, $scale));
    }

    /**
     * @return static
     */
    public function subtract(Number $operand, ?int $scale = null)
    {
        $this->assertOperand($operand);

        /** @psalm-suppress ImpureMethodCall */
        return $this->changeValue($this->value->sub($operand->value, $scale), $scale);
    }

    /**
     * @return static
     */
    public function toScale(int $scale)
    {
        /** @psalm-suppress ImpureMethodCall */
        return $this->changeValue($this->value->div(Decimal::create(10)->pow(Decimal::create($scale)), $scale));
    }

    protected function assertOperand(Number $operand): void
    {
        // scope to perform assertions to guard against improper operands
    }

    /**
     * @param mixed $value
     *
     * @throws \InvalidArgumentException
     */
    private function assignValue($value, ?int $scale = null): void
    {
        if ($value instanceof self) {
            $value = $value->value;
        }

        try {
            /** @psalm-suppress InaccessibleProperty, ImpureMethodCall */
            $this->value = Decimal::create($value, $scale);
        } catch (BigNumbersError $exception) {
            throw new \InvalidArgumentException($exception->getMessage(), 0, $exception);
        }
    }
}
