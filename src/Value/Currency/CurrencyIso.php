<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Currency;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
final class CurrencyIso
{
    /**
     * @var string[]|int[]
     */
    private static $currencies;

    /**
     * @ORM\Column(type="string", length=3)
     *
     * @var string
     */
    private $currency;

    /**
     * @param string $code ISO 4217 code (https://en.wikipedia.org/wiki/ISO_4217)
     */
    public function __construct($code)
    {
        $currencies = $this->getCurrencies();

        if (!isset($currencies[(string) $code])) {
            throw new \InvalidArgumentException(\sprintf('Given value "%s" is not a valid ISO 4217 code', $code));
        }

        $this->currency = $currencies[(string) $code]['alphabeticCode'];
    }

    public function equals(self $comparator): bool
    {
        return $this->currency === $comparator->currency;
    }

    public function getMinorUnit(): int
    {
        return $this->getCurrencies()[$this->currency]['minorUnit'];
    }

    public function __toString(): string
    {
        return $this->currency;
    }

    /**
     * @return string[]|int[]
     */
    private function getCurrencies(): array
    {
        if (null === self::$currencies) {
            self::$currencies = require __DIR__.'/../../../vendor/moneyphp/money/resources/currency.php';
        }

        return self::$currencies;
    }
}
