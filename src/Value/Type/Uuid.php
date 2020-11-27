<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Type;

use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid as RamseyUuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @psalm-immutable
 */
abstract class Uuid
{
    /** @var UuidInterface */
    protected $uuid;

    final private function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @param string $bytes
     *
     * @return static
     *
     * @psalm-pure
     */
    public static function fromBytes($bytes)
    {
        return new static(RamseyUuid::fromBytes($bytes));
    }

    /**
     * @param string $namespace Must be a valid uuid on itself
     *
     * @return static
     *
     * @throws InvalidUuidStringException
     *
     * @psalm-pure
     */
    public static function fromNumericId(string $namespace, int $numericId): Uuid
    {
        return new static(RamseyUuid::uuid5($namespace, (string) $numericId));
    }

    /**
     * @param string $string
     *
     * @return static
     *
     * @psalm-pure
     */
    public static function fromString($string)
    {
        return new static(RamseyUuid::fromString($string));
    }

    /**
     * @return static
     *
     * @psalm-pure
     */
    public static function generate()
    {
        /** @psalm-suppress ImpureMethodCall */
        return new static(RamseyUuid::uuid4());
    }

    public function __toString(): string
    {
        return $this->uuid->toString();
    }

    public function bytes(): string
    {
        return $this->uuid->getBytes();
    }

    public function equals(Uuid $otherUuid): bool
    {
        return $this->uuid->equals($otherUuid->uuid);
    }
}
