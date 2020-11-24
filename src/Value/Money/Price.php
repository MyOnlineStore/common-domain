<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Money;

use Doctrine\ORM\Mapping as ORM;
use MyOnlineStore\Common\Domain\Value\Arithmetic\Amount;

/**
 * @ORM\Embeddable
 *
 * @psalm-immutable
 */
final class Price
{
    public const PRECISION_CALC = 6;
    public const PRECISION_DISPLAY = 2;
    public const PRECISION_INTERMEDIATE = 7;

    /**
     * @ORM\Column(name="price", type="decimal", precision=15, scale=6)
     *
     * @var string
     *
     * @psalm-var numeric-string
     */
    private $amount;

    /**
     * @param float|int|string $amount
     */
    public function __construct($amount)
    {
        if (!\is_numeric($amount) && '' !== $amount) {
            throw new \InvalidArgumentException(\sprintf('%s is not a numeric value', $amount));
        }

        /** @psalm-suppress PropertyTypeCoercion */
        $this->amount = (string) $amount;
    }

    public function __toString(): string
    {
        return $this->amount;
    }

    public function absolute(): self
    {
        if ($this->isPositive() || $this->isZero()) {
            return $this;
        }

        return $this->invert();
    }

    /**
     * Returns a new Price object that represents the monetary value
     * of the addition of this Price object and another.
     */
    public function add(self $other, int $scale = self::PRECISION_CALC): self
    {
        $value = \bcadd($this->amount, $other->amount, $scale);

        return new self($value);
    }

    /**
     * add a percentage of the value represented by this Price
     * object and returns a new Price object
     *
     * @psalm-param numeric-string $percentage
     */
    public function addPercentage(string $percentage, int $scale = self::PRECISION_CALC): self
    {
        // Add a guard digit for intermediary step
        $percentualAmountToAdd = \bcadd(\bcdiv($percentage, '100', $scale + 1), '1', $scale);
        $priceWithPercentage = \bcmul($this->amount, $percentualAmountToAdd, $scale);

        return new self($priceWithPercentage);
    }

    public function asCents(int $roundingMode = \PHP_ROUND_HALF_EVEN): int
    {
        return (int) \round(\bcmul('100.0', $this->amount, self::PRECISION_CALC), 0, $roundingMode);
    }

    public static function asZero(): self
    {
        return new self(0);
    }

    public function divideBy(self $denominator, int $scale = self::PRECISION_CALC): self
    {
        $value = \bcdiv($this->amount, $denominator->amount, $scale);

        return new self($value);
    }

    public function divideByAmount(Amount $amount, int $scale = self::PRECISION_CALC): self
    {
        $value = \bcdiv($this->amount, (string) $amount, $scale);

        return new self($value);
    }

    /**
     * Checks whether the value represented by this object equals to the other
     */
    public function equals(self $other): bool
    {
        return 0 === $this->compareTo($other);
    }

    public static function fromCents(int $cents): self
    {
        return (new self($cents))->divideBy(new self(100));
    }

    /**
     * Get a percentage that was already added to the price, for example get the 21% of 121%
     *
     * @psalm-param numeric-string $percentage
     */
    public function getAddedPercentage(string $percentage, int $scale = self::PRECISION_CALC): self
    {
        $currentPercentage = \bcadd($percentage, '100', $scale + 1);
        $amountPerPercentage = \bcdiv($this->amount, $currentPercentage, $scale + 1);
        $amountForPercentage = \bcmul($amountPerPercentage, $percentage, $scale);

        return new self($amountForPercentage);
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    /**
     * Verkrijg een percentage van de huidige amount
     *
     * @psalm-param numeric-string $percentage
     */
    public function getPercentage(string $percentage, int $scale = self::PRECISION_CALC): self
    {
        // Add a guard digit for intermediary step
        $percentageToGet = \bcdiv($percentage, '100', $scale + 1);
        $percentageofAmount = \bcmul($this->amount, $percentageToGet, $scale);

        return new self($percentageofAmount);
    }

    public function invert(): self
    {
        return $this->multiplyBy(new self(-1));
    }

    /**
     * Checks whether the value represented by this object is greater than the other
     */
    public function isGreaterThan(self $other): bool
    {
        return 1 === $this->compareTo($other);
    }

    public function isGreaterThanOrEqualTo(self $other): bool
    {
        return $this->compareTo($other) >= 0;
    }

    /**
     * Checks whether the value represented by this object is less than the other
     */
    public function isLessThan(self $other): bool
    {
        return -1 === $this->compareTo($other);
    }

    public function isLessThanOrEqualTo(self $other): bool
    {
        return $this->compareTo($other) <= 0;
    }

    /**
     * Checks if the value represented by this object is negative
     */
    public function isNegative(): bool
    {
        return -1 === $this->compareTo0();
    }

    /**
     * Checks if the value represented by this object is positive
     */
    public function isPositive(): bool
    {
        return 1 === $this->compareTo0();
    }

    /**
     * Checks if the value represented by this object is zero
     */
    public function isZero(): bool
    {
        return 0 === $this->compareTo0();
    }

    public function multiplyBy(self $multiplicand, int $scale = self::PRECISION_CALC): self
    {
        $value = \bcmul($this->amount, $multiplicand->amount, $scale);

        return new self($value);
    }

    public function multiplyByAmount(Amount $amount, int $scale = self::PRECISION_CALC): self
    {
        $value = \bcmul($this->amount, (string) $amount, $scale);

        return new self($value);
    }

    public function round(int $decimals = self::PRECISION_DISPLAY): self
    {
        return new self(\number_format((float) $this->amount, $decimals, '.', ''));
    }

    /**
     * Returns a new Price object that represents the difference of this Price object and another.
     */
    public function subtract(self $other, int $scale = self::PRECISION_CALC): self
    {
        $value = \bcsub($this->amount, $other->amount, $scale);

        return new self($value);
    }

    /**
     * Extracts a percentage of the value represented by this Price
     * object and returns a new Price object
     *
     * @psalm-param numeric-string $percentage
     */
    public function subtractPercentage(string $percentage, int $scale = self::PRECISION_CALC): self
    {
        // Add a guard digit for intermediary step
        $percentualAmountToSubtract = \bcadd(\bcdiv($percentage, '100', $scale + 1), '1', $scale);
        $priceWithoutPercentage = \bcdiv($this->amount, $percentualAmountToSubtract, $scale);

        return new self($priceWithoutPercentage);
    }

    /**
     * Returns an integer less than, equal to, or greater than zero
     * if the value of this object is considered to be respectively
     * less than, equal to, or greater than the other
     */
    private function compareTo(self $other): int
    {
        return \bccomp($this->amount, $other->amount, self::PRECISION_CALC);
    }

    /**
     * Returns an integer less than, equal to, or greater than zero
     * if the value of this object is considered to be respectively
     * less than, equal to, or greater than 0
     */
    private function compareTo0(): int
    {
        return \bccomp($this->amount, '0', self::PRECISION_CALC);
    }
}
