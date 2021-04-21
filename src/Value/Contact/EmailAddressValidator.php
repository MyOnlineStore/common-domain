<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Contact;

interface EmailAddressValidator
{
    /**
     * @psalm-pure
     */
    public function __invoke(string $emailAddress): bool;
}
