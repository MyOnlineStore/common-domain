<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Person;

final class BirthDate
{
    private const FORMAT = 'Y-m-d';

    /** @var \DateTimeImmutable */
    private $date;

    private function __construct(\DateTimeImmutable $date)
    {
        $this->date = $date;
    }

    public static function fromString(
        string $time,
        string $format = self::FORMAT,
        string $timezone = 'UTC'
    ): self {
        /** @psalm-suppress PossiblyFalseArgument */

        return new self(
            \DateTimeImmutable::createFromFormat(
                $format,
                $time,
                new \DateTimeZone($timezone)
            )
        );
    }

    public function equals(self $comparator): bool
    {
        return (string) $this === (string) $comparator;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @psalm-suppress InvalidToString
     */
    public function __toString(): string
    {
        return $this->date->format(self::FORMAT);
    }
}
