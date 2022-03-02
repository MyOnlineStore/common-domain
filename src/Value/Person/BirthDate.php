<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Person;

use CuyZ\Valinor\Attribute\StaticMethodConstructor;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 *
 * @StaticMethodConstructor("fromString")
 *
 * @psalm-immutable
 */
final class BirthDate
{
    private const FORMAT = 'Y-m-d';

    /**
     * @ORM\Column(name="birth_date", type="date_immutable")
     */
    private \DateTimeImmutable $date;

    private function __construct(\DateTimeImmutable $date)
    {
        $this->date = $date;
    }

    /**
     * @psalm-suppress InvalidToString
     */
    public function __toString(): string
    {
        return $this->date->format(self::FORMAT);
    }

    public function equals(self $comparator): bool
    {
        return (string) $this === (string) $comparator;
    }

    /**
     * @psalm-pure
     */
    public static function fromDateTime(\DateTimeImmutable $date): self
    {
        return new self($date);
    }

    /**
     * @psalm-pure
     */
    public static function fromString(string $date): self
    {
        return self::fromStringWithFormat($date);
    }

    /**
     * @psalm-pure
     */
    public static function fromStringWithFormat(
        string $date,
        string $format = self::FORMAT
    ): self {
        /** @psalm-suppress PossiblyFalseArgument */

        return new self(\DateTimeImmutable::createFromFormat($format, $date));
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }
}
