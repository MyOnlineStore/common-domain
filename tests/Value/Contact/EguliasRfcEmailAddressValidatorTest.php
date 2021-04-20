<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Value\Contact;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;
use MyOnlineStore\Common\Domain\Value\Contact\EguliasRfcEmailAddressValidator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class EguliasRfcEmailAddressValidatorTest extends TestCase
{
    /** @var EmailValidator&MockObject */
    private EmailValidator|MockObject $eguliasValidator;

    /** @var RFCValidation&MockObject */
    private RFCValidation|MockObject $validation;

    private EguliasRfcEmailAddressValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new EguliasRfcEmailAddressValidator(
            $this->eguliasValidator = $this->createMock(EmailValidator::class),
            $this->validation = $this->createMock(RFCValidation::class)
        );
    }

    public function testValidator(): void
    {
        $this->eguliasValidator->expects(self::exactly(2))
            ->method('isValid')
            ->withConsecutive(
                ['foo@bar.com', $this->validation],
                ['foo@bar.com', $this->validation],
            )
            ->willReturnOnConsecutiveCalls(
                false,
                true,
            );

        self::assertFalse(($this->validator)('foo@bar.com'));
        self::assertTrue(($this->validator)('foo@bar.com'));
    }
}
