<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Web;

use MyOnlineStore\Common\Domain\Assertion\EnumValueGuardTrait;

final class UrlPathType
{
    use EnumValueGuardTrait;

    const ABSOLUTE_URL = 0;
    const ABSOLUTE_PATH = 1;
    const RELATIVE_PATH = 2;
    const NETWORK_PATH = 3;

    /** @var int */
    private $value;

    public function __construct(int $value)
    {
        $this->guardIsValidValue($value);
        $this->value = $value;
    }

    public static function asAbsolutePath(): self
    {
        return new self(self::ABSOLUTE_PATH);
    }

    public static function asAbsoluteUrl(): self
    {
        return new self(self::ABSOLUTE_URL);
    }

    public static function asNetworkPath(): self
    {
        return new self(self::NETWORK_PATH);
    }

    public static function asRelativePath(): self
    {
        return new self(self::RELATIVE_PATH);
    }

    public function equals(self $comparator): bool
    {
        return $this->value === $comparator->value;
    }

    public function toInt(): int
    {
        return $this->value;
    }

    /**
     * @return int[]
     */
    protected function getValidValues(): array
    {
        return [
            self::ABSOLUTE_URL,
            self::ABSOLUTE_PATH,
            self::RELATIVE_PATH,
            self::NETWORK_PATH,
        ];
    }
}
