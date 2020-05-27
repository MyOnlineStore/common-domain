<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Type;

use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

abstract class AbstractUuid
{
    /** @var UuidInterface */
    protected $uuid;

    /**
     * @param UuidInterface $uuid
     */
    private function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @param string $bytes
     *
     * @return static
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
     * @throws InvalidUuidStringException If the namespace is not a valid uuid
     */
    public static function fromNumericId(string $namespace, int $numericId): AbstractUuid
    {
        return new static(Uuid::uuid5($namespace, (string) $numericId));
    }

    /**
     * @param string $string
     *
     * @return static
     */
    public static function fromString($string)
    {
        return new static(Uuid::fromString($string));
    }

    /**
     * @return static
     */
    public static function generate()
    {
        return new static(Uuid::uuid4());
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->uuid->toString();
    }

    /**
     * @return string
     */
    public function bytes()
    {
        return $this->uuid->getBytes();
    }

    /**
     * @param AbstractUuid $otherUuid
     *
     * @return bool
     */
    public function equals(AbstractUuid $otherUuid)
    {
        return $this->uuid->equals($otherUuid->uuid);
    }
}
