<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Web;

use Doctrine\ORM\Mapping as ORM;
use MyOnlineStore\Common\Domain\Assertion\EnumValueGuardTrait;

/**
 * @ORM\Embeddable
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

    public static function asSmall(): self
    {
        return new static(self::SMALL);
    }

    public static function asMedium(): self
    {
        return new static(self::MEDIUM);
    }

    public static function asLarge(): self
    {
        return new static(self::LARGE);
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
     * @return string[]
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
