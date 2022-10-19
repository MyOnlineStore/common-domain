<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Location\Address;

use Doctrine\ORM\Mapping as ORM;
use MyOnlineStore\Common\Domain\Assertion\Assert;
use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

/**
 * @ORM\Embeddable
 *
 * @psalm-immutable
 */
final class ZipCode
{
    // not all countries use zipCodes, see SCS-417 and https://gist.github.com/kennwilson/3902548
    private const NOT_AVAILABLE = 'N/A';

    /**
     * @ORM\Column(name="zip_code", length=10)
     *
     * @var string
     */
    private $zipCode;

    private function __construct(string $zipCode)
    {
        $this->zipCode = $zipCode;
    }

    /**
     * @throws InvalidArgument
     *
     * @psalm-pure
     */
    public static function fromString(string $zipCode): self
    {
        Assert::notWhitespaceOnly($zipCode);

        return new self(\mb_strtoupper($zipCode));
    }

    /** @psalm-pure */
    public static function asNotAvailable(): self
    {
        return new self(self::NOT_AVAILABLE);
    }

    public function equals(self $comparison): bool
    {
        return \str_replace(' ', '', $this->zipCode) === \str_replace(' ', '', $comparison->zipCode);
    }

    public function __toString(): string
    {
        return $this->zipCode;
    }
}
