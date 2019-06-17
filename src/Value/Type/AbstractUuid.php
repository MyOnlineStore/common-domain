<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Type;

use MyOnlineStore\Common\Domain\Exception\InvalidUuidProvidedException;
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

    /**
     *
     * @return static
     *
     * @throws InvalidUuidProvidedException
     */
    public static function fromBytes(string $bytes)
    {
        try {
            return new static(Uuid::fromBytes($bytes));
        } catch (\InvalidArgumentException $exception) {
        }

        throw new InvalidUuidProvidedException('invalid uuid provided', $exception->getCode(), $exception);
    }

    /**
     *
     * @return static
     *
     * @throws InvalidUuidProvidedException
     */
    public static function fromString(string $string)
    {
        try {
            return new static(Uuid::fromString($string));
        } catch (InvalidUuidStringException $exception) {
        }

        throw new InvalidUuidProvidedException('invalid uuid provided', $exception->getCode(), $exception);
    }

    /**
     * @return static
     */
    public static function generate()
    {
        /** @noinspection PhpUnhandledExceptionInspection */

        return new static(Uuid::uuid4());
    }
}
