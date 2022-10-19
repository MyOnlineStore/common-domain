<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Exception\Web;

use MyOnlineStore\Common\Domain\Exception\NotFoundException;

/** @psalm-immutable */
final class UrlNotFound extends NotFoundException
{
}
