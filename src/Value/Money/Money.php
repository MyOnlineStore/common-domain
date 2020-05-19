<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Money;

use MyOnlineStore\Common\Domain\Value\Arithmetic\Amount;

final class Money
{
    /** @var Amount */
    private $amount;

    /** @var CurrencyIso */
    private $currency;

    public function __construct(Amount $amount, CurrencyIso $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function add(self $otherMoney): self
    {
        if (!$this->currency->equals($otherMoney->currency)) {
            throw new \InvalidArgumentException(
                \sprintf('Cannot mix %s currency with %s', $this->currency, $otherMoney->currency)
            );
        }

        return new self($this->amount->add($otherMoney->amount), $this->currency);
    }

    /**
     * @param int|string|float $amount
     *
     */
    public static function fromFractionated($amount, CurrencyIso $currency): self
    {
        if (false !== \strpos($amount, ',')) {
            throw new \InvalidArgumentException(\sprintf('cannot use comma separated amount "%s"', $amount));
        }

        return new self(
            new Amount(
                (int) \bcmul(
                    (string) \round($amount, $currency->getMinorUnit()),
                    \sprintf('1%s', \str_repeat('0', $currency->getMinorUnit())),
                    $currency->getMinorUnit()
                )
            ),
            $currency
        );
    }

    public function equals(self $comparator): bool
    {
        return $this->currency->equals($comparator->currency) &&
            $this->amount->equals($comparator->amount);
    }

    public function getAmount(): Amount
    {
        return $this->amount;
    }

    public function getCurrency(): CurrencyIso
    {
        return $this->currency;
    }

    public function __toString(): string
    {
        return \bcdiv(
            (string) $this->amount,
            \sprintf('1%s', \str_repeat('0', $this->currency->getMinorUnit())),
            $this->currency->getMinorUnit()
        );
    }
}
