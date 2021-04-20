<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Value\Tax;

interface VatNumberValidator
{
    /**
     * @psalm-pure
     */
    public function __invoke(string $vatNumber): bool;
}
