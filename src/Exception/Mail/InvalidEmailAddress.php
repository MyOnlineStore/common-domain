<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Exception\Mail;

use MyOnlineStore\Common\Domain\Exception\InvalidArgument;

/** @psalm-immutable */
final class InvalidEmailAddress extends InvalidArgument
{
}
