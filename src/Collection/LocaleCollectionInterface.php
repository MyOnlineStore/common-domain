<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Collection;

use MyOnlineStore\Common\Domain\Value\CurrencyIso;
use MyOnlineStore\Common\Domain\Value\Locale;

/**
 * @method Locale[] getIterator()
 */
interface LocaleCollectionInterface extends ImmutableCollectionInterface, StringCollectionInterface
{
    /**
     * @return RegionCodeCollectionInterface
     */
    public function asRegionCodes(): RegionCodeCollectionInterface;

    /**
     * @param CurrencyIso $currencyIso
     * @param float       $previewAmount
     *
     * @return LocaleCollectionInterface[]
     */
    public function groupByCurrencyFormat($currencyIso, $previewAmount): array;

    /**
     * @return LocaleCollectionInterface
     */
    public function unique(): LocaleCollectionInterface;
}
