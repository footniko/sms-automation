<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SmsLog
 * ============
 *
 * Represents a db model, that is responsible for sms campaigns logging
 *
 * @package App
 */
class SmsLog extends Model
{
    /**
     * The name of the "updated at" column. We just make it not usable by Laravel
     *
     * @var string
     */
    const UPDATED_AT = null;

    /**
     * Fields that will be allowed for mass assignment
     *
     * @var array
     */
    protected $fillable = ['sms_queue_id', 'message', 'status'];
}
