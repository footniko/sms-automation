<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * Class `SmsCampaignStatus`
 * ========================
 *
 * This is a ENUM class that represents supported sms' statuses.
 */
final class SmsCampaignStatus extends Enum
{
    const ACTIVE = 'Active';
    const STOPPED = 'Stopped';
    const SENT = 'Sent';
    const PAUSED = 'Paused';
}
