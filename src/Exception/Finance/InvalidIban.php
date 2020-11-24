<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Exception\Finance;

use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

/**
 * @psalm-immutable
 */
final class InvalidIban extends InvalidArgument
{
}
