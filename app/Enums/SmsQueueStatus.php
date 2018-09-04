<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * Class `SmsQueueStatus`
 * ======================
 *
 * This is a ENUM class that represents supported sms' queue statuses.
 */
final class SmsQueueStatus extends Enum
{
    const WAITING = 'Waiting';
    const SENT = 'Sent';
    const CANCELLED = 'Cancelled';
}
