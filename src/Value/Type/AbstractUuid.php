<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Type;

use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/** @psalm-immutable */
abstract class AbstractUuid
{
    /** @var UuidInterface $uuid */
    protected $uuid;

    final private function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    /** @psalm-pure */
    public static function fromBytes(string $bytes): static
    {
        return new static(Uuid::fromBytes($bytes));
    }

    /**
     * @param string $namespace Must be a valid uuid on itself
     *
     * @throws InvalidUuidStringException
     *
     * @psalm-pure
     */
    public static function fromNumericId(string $namespace, int $numericId): static
    {
        return new static(Uuid::uuid5($namespace, (string) $numericId));
    }

    /** @psalm-pure */
    public static function fromString(string $string): static
    {
        return new static(Uuid::fromString($string));
    }

    /** @psalm-pure */
    public static function generate(): static
    {
        /** @psalm-suppress ImpureMethodCall */
        return new static(Uuid::uuid4());
    }

    public function bytes(): string
    {
        return $this->uuid->getBytes();
    }

    public function equals(AbstractUuid $otherUuid): bool
    {
        return $this->uuid->equals($otherUuid->uuid);
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }

    public function __toString(): string
    {
        return $this->uuid->toString();
    }
}
