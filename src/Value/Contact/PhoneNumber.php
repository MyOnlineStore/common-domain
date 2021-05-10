<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Contact;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumber as LibPhoneNumber;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberUtil;
use MyOnlineStore\Common\Domain\Exception\Contact\InvalidPhoneNumber;
use MyOnlineStore\Common\Domain\Value\RegionCode;

/**
 * @final
 * @psalm-immutable
 */
class PhoneNumber
{
    private PhoneNumberUtil $phoneNumberUtil;
    private LibPhoneNumber $value;

    /**
     * @throws \InvalidArgumentException
     */
    public function __construct(string $value, RegionCode $regionCode)
    {
        $this->phoneNumberUtil = PhoneNumberUtil::getInstance();

        try {
            /** @psalm-suppress ImpureMethodCall */
            $this->value = $this->phoneNumberUtil->parse($value, $regionCode->toString());
        } catch (NumberParseException $exception) {
            throw InvalidPhoneNumber::withPhoneNumber($value, $exception);
        }
    }

    public function equals(self $other): bool
    {
        /** @psalm-suppress ImpureMethodCall */
        return $this->value->equals($other->value);
    }

    public function getCountryCode(): ?int
    {
        return $this->value->getCountryCode();
    }

    public function getFormatted(): string
    {
        /** @psalm-suppress ImpureMethodCall */
        return \str_replace('+', '00', $this->phoneNumberUtil->format($this->value, PhoneNumberFormat::E164));
    }

    public function getShortInternationalFormat(): string
    {
        /** @psalm-suppress ImpureMethodCall */
        return $this->phoneNumberUtil->format($this->value, PhoneNumberFormat::E164);
    }

    public function isFixedLine(): bool
    {
        /** @psalm-suppress ImpureMethodCall */
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
        /** @psalm-suppress ImpureMethodCall */
        return \in_array(
            $this->phoneNumberUtil->getNumberType($this->value),
            [
                PhoneNumberType::MOBILE,
                PhoneNumberType::FIXED_LINE_OR_MOBILE,
            ],
            true
        );
    }

    public function toString(): string
    {
        return $this->getShortInternationalFormat();
    }

    /**
     * Create a new instance of this PhoneNumber with an other RegionCode
     */
    public function withRegionCode(RegionCode $regionCode): self
    {
        $nationalNumber = $this->value->getNationalNumber();
        \assert(null !== $nationalNumber);

        return new self($nationalNumber, $regionCode);
    }
}
