<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Type;

use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @psalm-immutable
 */
abstract class AbstractUuid
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
        return new static(Uuid::fromBytes($bytes));
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
    public static function fromNumericId(string $namespace, int $numericId): AbstractUuid
    {
        return new static(Uuid::uuid5($namespace, (string) $numericId));
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
        return new static(Uuid::fromString($string));
    }

    /**
     * @return static
     *
     * @psalm-pure
     */
    public static function generate()
    {
        /** @psalm-suppress ImpureMethodCall */
        return new static(Uuid::uuid4());
    }

    public function __toString(): string
    {
        return $this->uuid->toString();
    }

    public function bytes(): string
    {
        return $this->uuid->getBytes();
    }

    public function equals(AbstractUuid $otherUuid): bool
    {
        return $this->uuid->equals($otherUuid->uuid);
    }
}
