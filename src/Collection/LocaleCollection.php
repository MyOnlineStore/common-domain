<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Collection;

use MyOnlineStore\Common\Domain\Value\Locale;

final class LocaleCollection extends ArrayCollection implements LocaleCollectionInterface
{
    /**
     * @inheritdoc
     */
    public function __construct(array $entries = [])
    {
        parent::__construct(
            array_filter(
                $entries,
                function ($entry) {
                    return $entry instanceof Locale;
                }
            )
        );
    }

    /**
     * @inheritdoc
     */
    public function asRegionCodes()
    {
        return new RegionCodeCollection(
            array_values(
                array_unique(
                    array_map(
                        function (Locale $locale) {
                            return $locale->regionCode();
                        },
                        $this->toArray()
                    )
                )
            )
        );
    }

    /**
     * @inheritdoc
     */
    public function asStrings()
    {
        return array_values(array_map('strval', $this->toArray()));
    }

    /**
     * @inheritDoc
     */
    public function contains($element)
    {
        return $this->exists(
            function ($index, Locale $locale) use ($element) {
                return $locale->equals($element);
            }
        );
    }

    /**
     * @param string[] $input
     *
     * @return self
     */
    public static function fromStrings(array $input)
    {
        return new self(
            array_map(
                function ($locale) {
                    try {
                        return Locale::fromString($locale);
                    } catch (\InvalidArgumentException $exception) {
                        return false;
                    }
                },
                $input
            )
        );
    }

    /**
     * @inheritdoc
     */
    public function groupByCurrencyFormat($currencyIso, $previewAmount)
    {
        return $this->groupBy(
            function (Locale $locale) use ($currencyIso, $previewAmount) {
                $numberFormatter = new \NumberFormatter((string) $locale, \NumberFormatter::CURRENCY);

                return $numberFormatter->formatCurrency($previewAmount, (string) $currencyIso);
            }
        );
    }

    /**
     * @inheritdoc
     */
    public function unique(): LocaleCollectionInterface
    {
        return new LocaleCollection(\array_unique($this->toArray()));
    }

    /**
     * @param callable $callable
     *
     * @return LocaleCollection[]
     */
    private function groupBy(callable $callable)
    {
        $locales = [];

        foreach ($this as $locale) {
            $groupingValue = $callable($locale);

            if (!isset($locales[$groupingValue])) {
                $locales[$groupingValue] = new self();
            }

            $locales[$groupingValue][] = $locale;
        }

        return $locales;
    }
}
