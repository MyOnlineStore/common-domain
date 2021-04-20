<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Type;

use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid as RamseyUuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @psalm-consistent-constructor
 * @psalm-immutable
 */
abstract class Uuid
{
    private function __construct(
        protected UuidInterface $uuid
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function fromBytes(string $bytes): static
    {
        return new static(RamseyUuid::fromBytes($bytes));
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
        return new static(RamseyUuid::uuid5($namespace, (string) $numericId));
    }

    /**
     * @psalm-pure
     */
    public static function fromString(string $string): static
    {
        return new static(RamseyUuid::fromString($string));
    }

    /**
     * @psalm-pure
     */
    public static function generate(): static
    {
        /** @psalm-suppress ImpureMethodCall */
        return new static(RamseyUuid::uuid4());
    }

    public function equals(Uuid $other): bool
    {
        return $this->uuid->equals($other->uuid);
    }

    public function toBytes(): string
    {
        return $this->uuid->getBytes();
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }
}
