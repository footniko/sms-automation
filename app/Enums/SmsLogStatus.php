<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * Class `SmsLogStatus`
 * ====================
 *
 * This is a ENUM class that represents supported sms' log statuses.
 */
final class SmsLogStatus extends Enum
{
    const SUCCESS = 'Success';
    const FAILURE = 'Failure';
}
