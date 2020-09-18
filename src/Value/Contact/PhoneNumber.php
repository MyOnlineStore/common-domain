<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Contact;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumber as LibPhoneNumber;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberUtil;
use MyOnlineStore\Common\Domain\Value\RegionCode;

final class PhoneNumber
{
    /** @var PhoneNumberUtil */
    private $phoneNumberUtil;

    /** @var LibPhoneNumber */
    private $value;

    /**
     * @param string $value
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($value, ?RegionCode $regionCode = null)
    {
        $this->phoneNumberUtil = PhoneNumberUtil::getInstance();

        if (null === $regionCode) {
            $regionCode = RegionCode::asNL();
        }

        try {
            $this->value = $this->phoneNumberUtil->parse($value, (string) $regionCode);
        } catch (NumberParseException $exception) {
            throw new \InvalidArgumentException(
                \sprintf('Invalid phonenumber (%s)', $value),
                0,
                $exception
            );
        }
    }

    public function __toString(): string
    {
        return $this->getShortInternationalFormat();
    }

    public function equals(self $comparison): bool
    {
        return 0 === \strcasecmp((string) $this, (string) $comparison);
    }

    public function getCountryCode(): ?int
    {
        return $this->value->getCountryCode();
    }

    public function getFormatted(): string
    {
        return \str_replace('+', '00', $this->phoneNumberUtil->format($this->value, PhoneNumberFormat::E164));
    }

    public function getShortInternationalFormat(): string
    {
        return $this->phoneNumberUtil->format($this->value, PhoneNumberFormat::E164);
    }

    public function isFixedLine(): bool
    {
        return \in_array(
            $this->phoneNumberUtil->getNumberType($this->value),
            [
                PhoneNumberType::FIXED_LINE,
                PhoneNumberType::FIXED_LINE_OR_MOBILE,
            ],
            true
        );
    }

    public function isMobile(): bool
    {
        return \in_array(
            $this->phoneNumberUtil->getNumberType($this->value),
            [
                PhoneNumberType::MOBILE,
                PhoneNumberType::FIXED_LINE_OR_MOBILE,
            ],
            true
        );
    }

    /**
     * Create a new instance of this PhoneNumber with an other RegionCode
     */
    public function withRegionCode(RegionCode $regionCode): self
    {
        return new static($this->value->getNationalNumber(), $regionCode);
    }
}
