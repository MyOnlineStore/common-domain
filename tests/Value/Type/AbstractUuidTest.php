<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Type;

use MyOnlineStore\Common\Domain\Value\Type\AbstractUuid;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;

final class AbstractUuidTest extends TestCase
{
    public function testFromBytes()
    {
        $uuid = Uuid::fromString('3e5c88c3-8369-4404-8828-6a3927533387');

        self::assertEquals(
            $uuid->getBytes(),
            (string) UuidStub::fromBytes($uuid->getBytes())->bytes()
        );
    }

    public function testFromString()
    {
        self::assertEquals(
            '3e5c88c3-8369-4404-8828-6a3927533387',
            (string) UuidStub::fromString('3e5c88c3-8369-4404-8828-6a3927533387')
        );
    }

    public function testGenerate()
    {
        $uuid = Uuid::fromString((string) UuidStub::generate());

        self::assertInstanceOf(Uuid::class, $uuid);
        self::assertEquals(4, $uuid->getVersion());
    }

    public function testEquals()
    {
        $stub = UuidStub::fromString('b6094976-e5c7-4ddf-b35c-2f26d6fbcaec');

        self::assertTrue($stub->equals(UuidStub::fromString('b6094976-e5c7-4ddf-b35c-2f26d6fbcaec')));
        self::assertFalse($stub->equals(UuidStub::fromString('5de6f213-1f41-42e0-8e0d-d2828f352ebe')));
    }

    public function testSpecialUuids()
    {
        $uuid1 = UuidStub::fromString('0e703880-7f48-11e8-b8d7-44a8421b9960');
        $uuid2 = UuidStub::fromString('0e703936-7f48-11e8-b8d7-44a8421b9960');

        self::assertTrue($uuid1->equals($uuid1));
        self::assertFalse($uuid1->equals($uuid2));
        self::assertTrue($uuid2->equals($uuid2));
        self::assertFalse($uuid2->equals($uuid1));
    }

    public function testFromNumericId()
    {
        $uuid = UuidStub::fromNumericId('b6094976-e5c7-4ddf-b35c-2f26d6fbcaec', 123);

        self::assertEquals($uuid, UuidStub::fromNumericId('b6094976-e5c7-4ddf-b35c-2f26d6fbcaec', 123));
        self::assertNotEquals($uuid, UuidStub::fromNumericId('b6094976-e5c7-4ddf-b35c-2f26d6fbcaec', 124));
    }

    public function testFromNumericIdWithInvalidNamespace()
    {
        $this->expectException(InvalidUuidStringException::class);
        UuidStub::fromNumericId('foobar', 123);
    }
}

final class UuidStub extends AbstractUuid
{
}
