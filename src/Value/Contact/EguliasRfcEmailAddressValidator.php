<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Contact;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;

final class EguliasRfcEmailAddressValidator implements EmailAddressValidator
{
    public function __construct(
        private EmailValidator $validator,
        private RFCValidation $validation,
    ) {
    }

    /**
     * @psalm-pure
     */
    public function __invoke(string $emailAddress): bool
    {
        /** @psalm-suppress ImpureMethodCall, ImpurePropertyFetch, ImpureVariable */
        return $this->validator->isValid($emailAddress, $this->validation);
    }
}
