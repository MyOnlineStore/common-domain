<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Web;

use Doctrine\ORM\Mapping as ORM;
use MyOnlineStore\Common\Domain\Assertion\EnumValueGuardTrait;

/**
 * @ORM\Embeddable
 *
 * @psalm-immutable
 */
final class ViewPort
{
    use EnumValueGuardTrait;

    const SMALL = 'small';
    const MEDIUM = 'medium';
    const LARGE = 'large';

    /**
     * @ORM\Id
     * @ORM\Column(type="string", name="viewport")
     *
     * @var string
     */
    private $value;

    /**
     * @param string $value
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($value)
    {
        $this->guardIsValidValue($value);
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * @psalm-pure
     */
    public static function asSmall(): self
    {
        return new self(self::SMALL);
    }

    /**
     * @psalm-pure
     */
    public static function asMedium(): self
    {
        return new self(self::MEDIUM);
    }

    /**
     * @psalm-pure
     */
    public static function asLarge(): self
    {
        return new self(self::LARGE);
    }

    public function isSmall(): bool
    {
        return self::SMALL === $this->value;
    }

    public function isMedium(): bool
    {
        return self::MEDIUM === $this->value;
    }

    public function isLarge(): bool
    {
        return self::LARGE === $this->value;
    }

    /**
     * @return list<string>
     *
     * @psalm-pure
     */
    public static function getAvailableViewPorts(): array
    {
        return [self::SMALL, self::MEDIUM, self::LARGE];
    }

    /**
     * @return string[]
     */
    protected function getValidValues(): array
    {
        return self::getAvailableViewPorts();
    }
}
