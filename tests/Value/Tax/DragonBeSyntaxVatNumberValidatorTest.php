<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Tax;

use DragonBe\Test\Vies\Validator;
use MyOnlineStore\Common\Domain\Value\Tax\DragonBeSyntaxVatNumberValidator;
use PHPUnit\Framework\TestCase;

final class DragonBeSyntaxVatNumberValidatorTest extends TestCase
{
    private const TESTS = [
        'AT' => Validator\ValidatorATTest::class,
        'BE' => Validator\ValidatorBETest::class,
        'BG' => Validator\ValidatorBGTest::class,
        'CY' => Validator\ValidatorCYTest::class,
        'CZ' => Validator\ValidatorCZTest::class,
        'DE' => Validator\ValidatorDETest::class,
        'DK' => Validator\ValidatorDKTest::class,
        'EE' => Validator\ValidatorEETest::class,
        'EL' => Validator\ValidatorELTest::class,
        'ES' => Validator\ValidatorESTest::class,
        'FI' => Validator\ValidatorFITest::class,
        'FR' => Validator\ValidatorFRTest::class,
        'HR' => Validator\ValidatorHRTest::class,
        'HU' => Validator\ValidatorHUTest::class,
        'IE' => Validator\ValidatorIETest::class,
        'IT' => Validator\ValidatorITTest::class,
        'LU' => Validator\ValidatorLUTest::class,
        'LV' => Validator\ValidatorLVTest::class,
        'LT' => Validator\ValidatorLTTest::class,
        'MT' => Validator\ValidatorMTTest::class,
        'NL' => Validator\ValidatorNLTest::class,
        'PL' => Validator\ValidatorPLTest::class,
        'PT' => Validator\ValidatorPTTest::class,
        'RO' => Validator\ValidatorROTest::class,
        'SE' => Validator\ValidatorSETest::class,
        'SI' => Validator\ValidatorSITest::class,
        'SK' => Validator\ValidatorSKTest::class,
        'GB' => Validator\ValidatorGBTest::class,
        'XI' => Validator\ValidatorXITest::class,
        'EU' => Validator\ValidatorEUTest::class,
    ];

    private DragonBeSyntaxVatNumberValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new DragonBeSyntaxVatNumberValidator();
    }

    /**
     * @return \Generator<int, array{string, bool}>
     */
    public function vatNumberProvider(): \Generator
    {
        foreach (self::TESTS as $country => $test) {
            /** @var array{string, bool} $case */
            foreach ((new $test())->vatNumberProvider() as $case) {
                yield [$country . $case[0], $case[1]];
            }
        }

        yield ['UK12345', false];
        yield ['', false];
        yield ['NL', false];
    }

    /**
     * @dataProvider vatNumberProvider
     */
    public function testValidation(string $vatNumber, bool $isValid): void
    {
        self::assertSame($isValid, ($this->validator)($vatNumber));
    }
}
