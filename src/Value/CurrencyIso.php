<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value;

use Doctrine\ORM\Mapping as ORM;

/**
 * @deprecated Use MyOnlineStore\Common\Domain\Value\Currency\CurrencyIso
 *
 * @ORM\Embeddable
 */
final class CurrencyIso
{
    /**
     * @var array|null
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

    /**
     * @param object $object
     *
     * @return bool
     */
    public function equals($object): bool
    {
        return $this == $object;
    }

    /**
     * @return array
     */
    private function getCurrencies(): array
    {
        if (null === self::$currencies) {
            self::$currencies = require_once __DIR__.'/../../vendor/moneyphp/money/resources/currency.php';
        }

        return self::$currencies;
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return $this->currency;
    }

    /**
     * @return int
     */
    public function getMinorUnit()
    {
        return $this->getCurrencies()[$this->currency]['minorUnit'];
    }
}
