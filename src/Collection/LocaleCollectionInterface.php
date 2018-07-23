<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Collection;

use MyOnlineStore\Common\Domain\Value\CurrencyIso;
use MyOnlineStore\Common\Domain\Value\Locale;

/**
 * @method Locale[] getIterator()
 */
interface LocaleCollectionInterface extends ImmutableCollectionInterface
{
    /**
     * @return RegionCodeCollectionInterface
     */
    public function asRegionCodes();

    /**
     * @return string[]
     */
    public function asStrings();

    /**
     * @param CurrencyIso $currencyIso
     * @param float       $previewAmount
     *
     * @return LocaleCollectionInterface[]
     */
    public function groupByCurrencyFormat($currencyIso, $previewAmount);

    /**
     * @return LocaleCollectionInterface
     */
    public function unique(): LocaleCollectionInterface;
}
