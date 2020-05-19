<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Person;

use MyOnlineStore\Common\Domain\Exception\Person\InvalidGender;

final class Gender
{
    private const MALE = 'male';
    private const FEMALE = 'female';

    /** @var string */
    private $gender;

    private function __construct(string $gender)
    {
        $this->gender = $gender;
    }

    /**
     * @throws InvalidGender
     */
    public static function fromString(string $gender): self
    {
        if (!\in_array($gender, [self::MALE, self::FEMALE])) {
            throw new InvalidGender(\sprintf('Invalid gender "%s" provided', $gender));
        }

        return new self($gender);
    }

    public static function asMale(): self
    {
        return new self(self::MALE);
    }

    public static function asFemale(): self
    {
        return new self(self::FEMALE);
    }

    public function equals(self $comparator): bool
    {
        return $this->gender === $comparator->gender;
    }

    public function isMale(): bool
    {
        return self::MALE === $this->gender;
    }

    public function isFemale(): bool
    {
        return self::FEMALE === $this->gender;
    }

    public function __toString(): string
    {
        return $this->gender;
    }
}
