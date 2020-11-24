<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Person;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 *
 * @psalm-immutable
 */
final class BirthDate
{
    private const FORMAT = 'Y-m-d';

    /**
     * @ORM\Column(name="birth_date", type="date_immutable")
     *
     * @var \DateTimeImmutable
     */
    private $date;

    private function __construct(\DateTimeImmutable $date)
    {
        $this->date = $date;
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
    public static function fromString(
        string $time,
        string $format = self::FORMAT
    ): self {
        /** @psalm-suppress PossiblyFalseArgument */

        return new self(\DateTimeImmutable::createFromFormat($format, $time));
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
