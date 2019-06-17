<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Type;

use InvalidArgumentException;
use MyOnlineStore\Common\Domain\Exception\InvalidUuidProvidedException;
use MyOnlineStore\Common\Domain\Value\Type\AbstractUuid;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;

final class AbstractUuidTest extends TestCase
{
    /**
     * @throws InvalidUuidProvidedException
     * @throws InvalidUuidStringException
     */
    public function testEquals()
    {
        $stub = UuidStub::fromString('b6094976-e5c7-4ddf-b35c-2f26d6fbcaec');

        self::assertTrue($stub->equals(UuidStub::fromString('b6094976-e5c7-4ddf-b35c-2f26d6fbcaec')));
        self::assertFalse($stub->equals(UuidStub::fromString('5de6f213-1f41-42e0-8e0d-d2828f352ebe')));
    }

    /**
     * @throws InvalidUuidProvidedException
     * @throws InvalidUuidStringException
     */
    public function testFromBytes()
    {
        $uuid = Uuid::fromString('3e5c88c3-8369-4404-8828-6a3927533387');

        self::assertEquals(
            $uuid->getBytes(),
            UuidStub::fromBytes($uuid->getBytes())->bytes()
        );
    }

    /**
     * @throws InvalidUuidProvidedException
     */
    public function testFromBytesWillThrowExceptionIfIncorrectUiidIsUsed()
    {
        $innerException = new InvalidArgumentException();

        $this->expectExceptionObject(
            new InvalidUuidProvidedException('invalid uuid provided', $innerException->getCode(), $innerException)
        );

        UuidStub::fromBytes('foo')->bytes();
    }

    /**
     * @throws InvalidUuidProvidedException
     */
    public function testFromString()
    {
        self::assertEquals(
            '3e5c88c3-8369-4404-8828-6a3927533387',
            (string) UuidStub::fromString('3e5c88c3-8369-4404-8828-6a3927533387')
        );
    }

    /**
     * @throws InvalidUuidProvidedException
     */
    public function testFromStringWillThrowExceptionIfIncorrectUiidIsUsed()
    {
        $innerException = new InvalidArgumentException();

        $this->expectExceptionObject(
            new InvalidUuidProvidedException('invalid uuid provided', $innerException->getCode(), $innerException)
        );

        UuidStub::fromString('foo')->bytes();
    }

    /**
     * @throws InvalidUuidStringException
     */
    public function testGenerate()
    {
        $uuid = Uuid::fromString((string) UuidStub::generate());

        self::assertEquals(4, $uuid->getVersion());
    }

    /**
     * @throws InvalidUuidProvidedException
     * @throws InvalidUuidStringException
     */
    public function testSpecialUuids()
    {
        $uuid1 = UuidStub::fromString('0e703880-7f48-11e8-b8d7-44a8421b9960');
        $uuid2 = UuidStub::fromString('0e703936-7f48-11e8-b8d7-44a8421b9960');

        self::assertTrue($uuid1->equals($uuid1));
        self::assertFalse($uuid1->equals($uuid2));
        self::assertTrue($uuid2->equals($uuid2));
        self::assertFalse($uuid2->equals($uuid1));
    }
}

final class UuidStub extends AbstractUuid
{
}
