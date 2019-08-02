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
    public function asRegionCodes(): RegionCodeCollectionInterface;

    /**
     * @return LocaleCollectionInterface[]
     */
    public function groupByCurrencyFormat(CurrencyIso $currencyIso, float $previewAmount): array;

    public function unique(): LocaleCollectionInterface;
}
