<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Exception\Person;

use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

/**
 * @psalm-immutable
 */
final class InvalidGender extends InvalidArgument
{
}
