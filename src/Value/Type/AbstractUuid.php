<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Type;

use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

abstract class AbstractUuid
{
    /**
     * @var UuidInterface
     */
    protected $uuid;

    private function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return static
     */
    public static function fromBytes(string $bytes): AbstractUuid
    {
        return new static(Uuid::fromBytes($bytes));
    }

    /**
     * @param string $namespace Must be a valid uuid on itself
     *
     * @return static
     *
     * @throws InvalidUuidStringException If the namespace is not a valid uuid
     */
    public static function fromNumericId(string $namespace, int $numericId): AbstractUuid
    {
        return new static(Uuid::uuid5($namespace, (string) $numericId));
    }

    /**
     * @return static
     *
     * @throws InvalidUuidStringException
     */
    public static function fromString(string $string): AbstractUuid
    {
        return new static(Uuid::fromString($string));
    }

    /**
     * @return static
     *
     * @throws \Exception
     */
    public static function generate(): AbstractUuid
    {
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
