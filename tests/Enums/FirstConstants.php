<?php

namespace Belca\Support\Tests\Enums;

use Belca\Support\AbstractEnums;

class FirstConstants extends AbstractEnums
{
    const DEFAULT = self::USER;

    const USER = 'user';
    const SUPERUSER = 'superuser';
    const CLIENT = 'client';
    const MODERATOR = 'moderator';
    const SUPERMODERATOR = 'super'.self::USER;
}
