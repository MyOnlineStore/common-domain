<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Exception\Finance;

use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

final class InvalidBic extends InvalidArgument
{
    public static function withBic(string $bic): self
    {
        return new self(\sprintf('The provided BIC "%s" is invalid', $bic));
    }
}
