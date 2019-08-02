<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
final class CurrencyIso
{
    /**
     * @var string[]|int[]|null
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
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(string $code)
    {
        $currencies = $this->getCurrencies();

        if (!isset($currencies[$code])) {
            throw new \InvalidArgumentException(\sprintf('Given value "%s" is not a valid ISO 4217 code', $code));
        }

        $this->currency = $currencies[$code]['alphabeticCode'];
    }

    public function equals(self $object): bool
    {
        return $this->currency === $object->currency;
    }

    public function __toString(): string
    {
        return $this->currency;
    }

    public function getMinorUnit(): int
    {
        return $this->getCurrencies()[$this->currency]['minorUnit'];
    }

    /**
     * @return string[]|int[]
     */
    private function getCurrencies(): array
    {
        if (null === self::$currencies) {
            self::$currencies = require __DIR__.'/../../vendor/moneyphp/money/resources/currency.php';
        }

        return self::$currencies;
    }
}
