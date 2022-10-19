<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Exception\Currency;

use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

/** @psalm-immutable */
final class InvalidCurrencyIso extends InvalidArgument
{
}
