<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Tax;

use DragonBe\Vies\Validator;

final class DragonBeSyntaxVatNumberValidator implements VatNumberValidator
{
    /** @const array<string, class-string<Validator\ValidatorInterface>> */
    private const VALIDATORS = [
        'AT' => Validator\ValidatorAT::class,
        'BE' => Validator\ValidatorBE::class,
        'BG' => Validator\ValidatorBG::class,
        'CY' => Validator\ValidatorCY::class,
        'CZ' => Validator\ValidatorCZ::class,
        'DE' => Validator\ValidatorDE::class,
        'DK' => Validator\ValidatorDK::class,
        'EE' => Validator\ValidatorEE::class,
        'EL' => Validator\ValidatorEL::class,
        'ES' => Validator\ValidatorES::class,
        'FI' => Validator\ValidatorFI::class,
        'FR' => Validator\ValidatorFR::class,
        'HR' => Validator\ValidatorHR::class,
        'HU' => Validator\ValidatorHU::class,
        'IE' => Validator\ValidatorIE::class,
        'IT' => Validator\ValidatorIT::class,
        'LU' => Validator\ValidatorLU::class,
        'LV' => Validator\ValidatorLV::class,
        'LT' => Validator\ValidatorLT::class,
        'MT' => Validator\ValidatorMT::class,
        'NL' => Validator\ValidatorNL::class,
        'PL' => Validator\ValidatorPL::class,
        'PT' => Validator\ValidatorPT::class,
        'RO' => Validator\ValidatorRO::class,
        'SE' => Validator\ValidatorSE::class,
        'SI' => Validator\ValidatorSI::class,
        'SK' => Validator\ValidatorSK::class,
        'GB' => Validator\ValidatorGB::class,
        'XI' => Validator\ValidatorXI::class,
        'EU' => Validator\ValidatorEU::class,
    ];

    /**
     * @psalm-pure
     */
    public function __invoke(string $vatNumber): bool
    {
        $country = \substr($vatNumber, 0, 2);

        if (!isset(self::VALIDATORS[$country])) {
            return false;
        }

        $validator = self::VALIDATORS[$country];

        /** @psalm-suppress ImpureMethodCall */
        return (new $validator())->validate(\substr($vatNumber, 2));
    }
}
