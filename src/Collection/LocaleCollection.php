<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Collection;

use MyOnlineStore\Common\Domain\Value\CurrencyIso;
use MyOnlineStore\Common\Domain\Value\Locale;

final class LocaleCollection extends MutableCollection implements LocaleCollectionInterface
{
    use StringCollectionTrait;

    /**
     * @param Locale[] $entries
     */
    public function __construct(array $entries = [])
    {
        parent::__construct(
            \array_filter(
                $entries,
                static function ($entry): bool {
                    return $entry instanceof Locale;
                }
            )
        );
    }

    public function asRegionCodes(): RegionCodeCollectionInterface
    {
        return new RegionCodeCollection(
            \array_values(
                \array_unique(
                    \array_map(
                        static function (Locale $locale) {
                            return $locale->regionCode();
                        },
                        $this->toArray()
                    )
                )
            )
        );
    }

    /**
     * @inheritDoc
     */
    public function contains($element): bool
    {
        return $this->containsWith(
            static function (Locale $locale) use ($element) {
                return $locale->equals($element);
            }
        );
    }

    /**
     * @return LocaleCollectionInterface[]
     */
    public function groupByCurrencyFormat(CurrencyIso $currencyIso, float $previewAmount): array
    {
        return $this->groupBy(
            static function (Locale $locale) use ($currencyIso, $previewAmount) {
                $numberFormatter = new \NumberFormatter((string) $locale, \NumberFormatter::CURRENCY);

                return $numberFormatter->formatCurrency($previewAmount, (string) $currencyIso);
            }
        );
    }

    public function unique(): LocaleCollectionInterface
    {
        return new LocaleCollection(\array_unique($this->toArray()));
    }

    /**
     * @param string[] $input
     */
    public static function fromStrings(array $input): self
    {
        return new self(
            \array_map(
                static function ($locale) {
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
     * @return LocaleCollection[]
     */
    private function groupBy(callable $callable): array
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
